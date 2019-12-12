<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Utils;
use App\Job;
use App\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $search = session('jobs_search', '');
        $job_types_selected = session('job_types_selected', []);
        $location = session('jobs_location', '');
        $city_id = session('jobs_city', null);
        $within = session('jobs_within');
        $within = !is_null($within) ? $within : 100;
        $job_types = Utils::getJobTypeFilter();
        $jobs = Job::has('user')->where('status', Job::STATUS_LIVE);
        if($job_types_selected) $jobs = $jobs->whereIn('type', $job_types_selected);
        if($location) $jobs = $jobs->where('address', 'like', '%'.$location.'%');
        if($city_id) $jobs = $jobs->where('city_id', $city_id);
        if($user && $user->hasLocation()){
            //$jobs = $jobs->where('lat', '<>', null)->where('lon', '<>', null)->whereRaw('(3959 * acos ( cos ( radians('.$user->lat.') ) * cos( radians(lat) ) * cos( radians(lon) - radians('.$user->lon.') ) + sin ( radians('.$user->lat.') ) * sin( radians(lat) ) ) ) < '.$within);
            $jobs = $jobs->where('coordinates', '<>', null)->whereRaw('69 * st_distance(Point('.$user->lon.','.$user->lat.'), Point(lon,lat)) < '.$within);
        }
        $jobs = $jobs->where(function ($query) use($search) {
                $query->where('title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhereHas('user', function ($query) use($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
            })->orderBy('id', 'desc')->paginate(4);
        return view('public.jobs.index', ['jobs'=>$jobs, 'search'=>$search, 'job_types'=>$job_types, 'job_types_selected'=>$job_types_selected, 'location'=>$location, 'within'=>$within]);
    }

    public function search(Request $request)
    {
        session(['jobs_search'=>$request->jobs_search, 'job_types_selected'=>$request->types, 'jobs_location'=>$request->jobs_location, 'jobs_within'=>$request->within]);
        return redirect()->route($request->route);
    }

    public function topSearch($search, $location)
    {
        $city = City::where('name', $location)->first();
        $params = ['jobs_search'=>$search];
        if($city) $params['jobs_city'] = $city->id;
        session($params);
        return redirect()->route('jobs.index');
    }

    public function view($location, $role, $id)
    {
        $job = Job::find($id);
        abort_if(!$job, 404);
        abort_if(!$job->isLive(), 404);
        $company = $job->user;
        abort_if(!$company, 404);
        $other_jobs = $company->jobs()->where('status', Job::STATUS_LIVE)->where('id', '<>', $id)->orderBy('id', 'desc')->get();
        $user = Auth::user();
        return view('public.jobs.view', ['job'=>$job, 'company'=>$company, 'user'=>$user, 'other_jobs'=>$other_jobs, 'apply'=>false]);
    }

    public function apply($location, $role, $id)
    {
        $job = Job::find($id);
        abort_if(!$job, 404);
        $company = $job->user;
        abort_if(!$company, 404);
        $other_jobs = $company->jobs()->where('status', Job::STATUS_LIVE)->where('id', '<>', $id)->orderBy('id', 'desc')->get();
        $user = Auth::user();
        return view('public.jobs.view', ['job'=>$job, 'company'=>$company, 'user'=>$user, 'other_jobs'=>$other_jobs, 'apply'=>true]);
    }
}
