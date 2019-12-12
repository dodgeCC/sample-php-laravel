<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Job;
use App\Contact;
use Validator;

class HomeController extends Controller
{
    /**
     * Show the application splash screen.
     *
     * @return Response
     */
    public function index()
    {
        $search = session('jobs_search', '');
        $jobs = Job::has('user')->where('status', Job::STATUS_LIVE)->where(function ($query) use($search) {
                $query->where('title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhereHas('user', function ($query) use($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
            })->orderBy('id', 'desc')->paginate(12);
        return view('public.home', ['jobs'=>$jobs, 'search'=>$search]);
    }

    public function dashboard(Request $request)
    {
    	return redirect()->route($request->user()->getDashboardRoute());
    }

    public function cities(Request $request)
    {
        $cities = City::where('status', true)->where('country_id', $request->country_id)->orderBy('name', 'asc')->get();
        
        return response()->json(['cities' => $cities]);
    }

    public function about()
    {
        return view('public.about');
    }

    public function pricing()
    {
        return view('public.pricing');
    }

    public function candidates()
    {
        return view('public.candidates');
    }

    public function employers()
    {
        return view('public.employers');
    }

    public function contact(Request $request)
    {
        if ($request->isMethod('post')) {
            $validation = [
            'name' => ['required', 'max:100'],
            'email' => ['required', 'max:100'],
            'phone' => ['required', 'max:50'],
            'message' => ['required']
            ];

            Validator::make($request->all(), $validation, ['name.required'=>'Name is required.', 'email.required'=>'Email is required.', 'phone.required'=>'Phone is required.', 'message.required'=>'Message is required.'])->validate();

            $contact = new Contact;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->message = $request->message;
            $contact->save();

            $request->session()->flash('status', ['type'=>'success', 'message'=>'Message sent.']);

            return redirect()->route('contact');

        }else{
            return view('public.contact');
        }
    }

    public function investors()
    {
        return view('public.investors');
    }

    public function careers()
    {
        return view('public.careers');
    }

    public function press()
    {
        return view('public.press');
    }

    public function faq()
    {
        return view('public.faq');
    }

    public function howToSubmitAJob()
    {
        return view('public.job-submit-how');
    }

    public function profileBestPractices()
    {
        return view('public.profile-best-practices');
    }
}
