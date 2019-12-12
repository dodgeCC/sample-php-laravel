<?php

namespace App\Http\Controllers\Candidate;

use App\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $skills = $user->getSkillsDetails();
        return view('candidate.skills.index', ['skills'=>$skills]);
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
            'name' => ['required', 'max:100']
        ];

        $validator = Validator::make($request->all(), $validation, ['name.required'=>'Name is required.']);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => implode(' ', $validator->errors()->all())]);
        }else{
            $user = Auth::user();

            $skill = new Skill;
            $skill->user_id = $user->id;
            $skill->name = $request->name;
            $skill->years = $request->years;
            $skill->months = $request->months;
            $skill->save();

            return response()->json(['status' => 'success', 'skills' => json_encode($user->getSkillsDetails())]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        $validation = [
            'name' => ['required', 'max:100']
        ];

        $validator = Validator::make($request->all(), $validation, ['name.required'=>'Name is required.']);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => implode(' ', $validator->errors()->all())]);
        }else{
            $skill->name = $request->name;
            $skill->years = $request->years;
            $skill->months = $request->months;
            $skill->save();

            return response()->json(['status' => 'success', 'skill' => json_encode($skill->getDetails())]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        if($skill->delete()){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error']);
        }
    }
}
