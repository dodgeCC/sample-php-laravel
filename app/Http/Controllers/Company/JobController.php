<?php

namespace App\Http\Controllers\Company;

use App\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;
use App\City;
use App\Helpers\Utils;
use Validator;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $jobs = $user->getJobsCriteria([Job::STATUS_DRAFT, Job::STATUS_LIVE, Job::STATUS_EXPIRED])->orderBy('id', 'desc')->paginate(10);
        return view('company.jobs.index', ['jobs'=>$jobs]);
    }

    public function filled()
    {
        $user = Auth::user();
        $jobs = $user->getJobsCriteria([Job::STATUS_FILLED])->orderBy('updated_at', 'desc')->paginate(10);
        return view('company.jobs.filled', ['jobs'=>$jobs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        
        $job_types = Utils::getJobTypeFilter();
        $job_contract_intervals = Utils::getJobContractIntervalFilter();
        $countries = Country::where('status', true)->orderBy('name', 'asc')->get();
        if($country_id = session('country_id')){
            $cities = City::where('status', true)->where('country_id', $country_id)->orderBy('name', 'asc')->get();
        }else{
            $cities = collect([]);
        }
        return view('company.jobs.create', ['user'=>$user, 'job_types'=>$job_types, 'job_contract_intervals'=>$job_contract_intervals, 'countries'=>$countries, 'cities'=>$cities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = ['title' => ['required', 'max:50']];
        if($request->city_id) $validation['address'] = ['required'];
        if($request->address) $validation['city_id'] = ['required'];
        if($request->contract_length) $validation['contract_interval'] = ['required'];
        if($request->contract_interval) $validation['contract_length'] = ['required'];

        $request->session()->flash('country_id', $request->country_id);

        Validator::make($request->all(), $validation, ['title.required'=>'Job title is required.'])->validate();

        $user = Auth::user();

        $job = new Job;
        $job->title = $request->title;
        $job->description = $request->description;
        $job->type = $request->type;
        $job->city_id = $request->city_id;
        $job->address = $request->address;
        if($request->address){
            $coordinates = Utils::getCoordinatesFromAddress($request->address);
            if($coordinates){
                $job->lat = $coordinates[0];
                $job->lon = $coordinates[1];
                $job->coordinates = Utils::getPointFromCoordinates($coordinates);
            }
        }
        $job->wage = $request->wage;
        $job->contract_length = $request->contract_length;
        $job->contract_interval = $request->contract_interval;
        $job->user_id = $user->id;
        if($request->draft){
            $job->status = Job::STATUS_DRAFT;
        }else{
            $job->status = Job::STATUS_LIVE;
        }
        $job->save();

        $request->session()->flash('status', ['type'=>'success', 'message'=>'New job created.']);

        return redirect()->route('company.jobs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        $user = Auth::user();
        abort_if($job->user_id!=$user->id, 404);
        $successful_applications = $job->getSuccessfulApplications();
        return view('company.jobs.show', ['job'=>$job, 'user'=>$user, 'successful_applications'=>$successful_applications]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        $user = Auth::user();
        abort_if($job->user_id!=$user->id, 404);
        $job_types = Utils::getJobTypeFilter();
        $job_contract_intervals = Utils::getJobContractIntervalFilter();
        $countries = Country::where('status', true)->orderBy('name', 'asc')->get();
        $country_id = session('country_id');
        if($job->city || $country_id){
            if(!$country_id) $country_id = $job->city->country_id;
            $cities = City::where('status', true)->where('country_id', $country_id)->orderBy('name', 'asc')->get();
        }else{
            $cities = collect([]);
        }
        return view('company.jobs.edit', ['user'=>$user, 'job'=>$job, 'job_types'=>$job_types, 'job_contract_intervals'=>$job_contract_intervals, 'countries'=>$countries, 'cities'=>$cities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $validation = ['title' => ['required', 'max:50']];
        if($request->city_id) $validation['address'] = ['required'];
        if($request->address) $validation['city_id'] = ['required'];
        if($request->contract_length) $validation['contract_interval'] = ['required'];
        if($request->contract_interval) $validation['contract_length'] = ['required'];

        $request->session()->flash('country_id', $request->country_id);

        Validator::make($request->all(), $validation, ['title.required'=>'Job title is required.'])->validate();

        $user = Auth::user();

        $job->title = $request->title;
        $job->description = $request->description;
        $job->type = $request->type;
        $job->city_id = $request->city_id;
        if($request->address != $job->address){
            $job->address = $request->address;
            $coordinates = Utils::getCoordinatesFromAddress($request->address);
            if($coordinates){
                $job->lat = $coordinates[0];
                $job->lon = $coordinates[1];
                $job->coordinates = Utils::getPointFromCoordinates($coordinates);
            }
        }
        $job->wage = $request->wage;
        $job->contract_length = $request->contract_length;
        $job->contract_interval = $request->contract_interval;
        if($request->publish){
            $job->status = Job::STATUS_LIVE;
        }elseif($request->unpublish){
            $job->status = Job::STATUS_DRAFT;
        }
        $job->save();

        $request->session()->flash('status', ['type'=>'success', 'message'=>'Job updated.']);

        return redirect()->route('company.jobs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Job $job)
    {
        $user = Auth::user();
        abort_if($job->user_id!=$user->id, 404);
        $job->setDeleted();

        return response()->json(['message' => 'Job is deleted.']);
    }

    public function refresh(Request $request, Job $job)
    {
        $user = Auth::user();
        abort_if($job->user_id!=$user->id, 404);
        if($user->canCreateMoreJobs()){
            $job->setDraft();
            $status = 'success';
            $message = 'Job is set to draft';
        }else{
            $status = 'error';
            $message = 'You can only have a maximum of '.$user->getSubscription()->countMaxJobsText().' for this subscription plan. You may <a href="/settings#/subscription">upgrade</a> your subscription to create more jobs.';
        }

        return response()->json(['status' => $status, 'message'=>$message]);
    }
}
