<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Spark\Spark;
use Laravel\Cashier\Cashier;
use App\Subscription;
use App\Team;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Spark::plans();
        $currency_symbol = Cashier::usesCurrencySymbol();
        foreach($plans as $plan){
            $plan->subscriptions = Subscription::where('stripe_plan', $plan->id)->count();
        }
        return view('admin.plans.index', ['plans'=>$plans, 'currency_symbol'=>$currency_symbol]);
    }

    public function subscriptions()
    {
        $subscriptions = Subscription::orderBy('id', 'desc')->paginate(10);
        return view('admin.subscriptions.index', ['subscriptions'=>$subscriptions]);
    }

    public function teams()
    {
        $teams = Team::orderBy('id', 'desc')->paginate(10);
        return view('admin.teams.index', ['teams'=>$teams]);
    }

    public function showTeam($team)
    {
        return view('admin.teams.show', ['team'=>$team, 'user'=>$team->owner]);
    }
}
