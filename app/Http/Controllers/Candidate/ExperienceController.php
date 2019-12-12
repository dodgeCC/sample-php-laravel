<?php

namespace App\Http\Controllers\Candidate;

use App\Experience;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $experiences = $user->getExperiencesDetails();
        return view('candidate.experiences.index', ['experiences'=>$experiences]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = [
            'role' => ['required', 'max:100'],
            'company' => ['required', 'max:100'],
            'start' => ['required']
        ];

        $validator = Validator::make($request->all(), $validation, ['role.required'=>'Role is required.', 'company.required'=>'Company is required.', 'start.required'=>'Start date is required.']);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => implode(' ', $validator->errors()->all())]);
        }else{
            $user = Auth::user();

            $experience = new Experience;
            $experience->user_id = $user->id;
            $experience->role = $request->role;
            $experience->company = $request->company;
            $experience->description = $request->description;
            $experience->start = $request->start;
            $experience->end = $request->end;
            $experience->save();

            return response()->json(['status' => 'success', 'experiences' => json_encode($user->getExperiencesDetails())]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function show(Experience $experience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function edit(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experience $experience)
    {
        $validation = [
            'role' => ['required', 'max:100'],
            'company' => ['required', 'max:100'],
            'start' => ['required']
        ];

        $validator = Validator::make($request->all(), $validation, ['role.required'=>'Role is required.', 'company.required'=>'Company is required.']);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => implode(' ', $validator->errors()->all())]);
        }else{
            $experience->role = $request->role;
            $experience->company = $request->company;
            $experience->description = $request->description;
            $experience->start = $request->start;
            $experience->end = $request->end;
            $experience->save();

            return response()->json(['status' => 'success', 'experience' => json_encode($experience->getDetails())]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        if($experience->delete()){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error']);
        }
    }
}
