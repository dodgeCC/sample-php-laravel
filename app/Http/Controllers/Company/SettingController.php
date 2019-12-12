<?php

namespace App\Http\Controllers\Company;

use App\UserSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $settings = $user->getSettings();
        return view('company.notifications', ['settings'=>json_encode($settings)]);
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
        $user = Auth::user();
        $settings = $user->user_setting;
        if(!$settings){
            $settings = new UserSetting;
            $settings->user_id = $user->id;
            $settings->save();
        }

        $settings->receive_platform_updates = $request->receive_platform_updates == 'true';
        $settings->receive_news_via_email = $request->receive_news_via_email == 'true';
        $settings->save();

        return response()->json(['receive_platform_updates' => $settings->receive_platform_updates, 'receive_news_via_email' => $settings->receive_news_via_email]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserSetting  $userSetting
     * @return \Illuminate\Http\Response
     */
    public function show(UserSetting $userSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserSetting  $userSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSetting $userSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserSetting  $userSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSetting $userSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserSetting  $userSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSetting $userSetting)
    {
        //
    }
}
