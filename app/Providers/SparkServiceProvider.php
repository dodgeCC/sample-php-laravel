<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;
use Laravel\Spark\Exceptions\IneligibleForPlan;
use Laravel\Cashier\Cashier;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
    'vendor' => 'Your Company',
    'product' => 'Your Product',
    'street' => 'PO Box 111',
    'location' => 'Your Town, NY 12345',
    'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = null;

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = false;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
        Spark::afterLoginRedirectTo('/dashboard');

        Spark::validateUsersWith(function () {
            return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => 'required'
            ];
        });

        Spark::createUsersWith(function ($request) {
            $user = Spark::user();

            $data = $request->all();

            $user->forceFill([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role_id' => $data['role_id']
                ])->save();

            return $user;
        });

        Cashier::useCurrency('gbp', '£');

        Spark::useStripe()->noCardUpFront();

        Spark::plan('Single Job', 'single-plan')
        ->price(59)
        ->features([
            '1 30 day Job Post', 'PAYG', 'Applicant Tracking', 'Candidate Matching', 'Applicant Pipeline'
            ]);

        Spark::plan('Growth', 'growth-monthly-plan')
        ->price(199)
        ->features([
            '10 Jobs Per Month', 'Applicant Tracking', 'Job Marketing', 'Candidate Matching', 'Applicant Pipeline'
            ]);

        Spark::plan('Growth (annual)', 'growth-annual-plan')
        ->price(1990)
        ->yearly()
        ->features([
            '10 Jobs Per Month', 'Applicant Tracking', 'Job Marketing', 'Candidate Matching', 'Applicant Pipeline'
            ]);

        Spark::plan('Enterprise', 'enterprise-monthly-plan')
        ->price(799)
        ->maxTeams(1)
        //->maxTeamMembers(10)
        ->features([
            'All Growth Features', 'Unlimited Jobs', 'Multiple Users', 'Dedicated Job Marketing', 'Company Job Page', 'ATS Integration'
            ]);

        Spark::plan('Enterprise (annual)', 'enterprise-annual-plan')
        // ->archived() archive plan
        ->price(7990)
        ->maxTeams(1)
        //->maxTeamMembers(10)
        ->yearly()
        ->features([
            'All Growth Features', 'Unlimited Jobs', 'Multiple Users', 'Dedicated Job Marketing', 'Company Job Page', 'ATS Integration'
            ]);

        

        Spark::checkPlanEligibilityUsing(function ($user, $plan) {
            if ($plan->id == 'single-plan' && $user->countAllJobs() > 1) {
                throw IneligibleForPlan::because('Single Job subscription limits you to only one job. You currently have '.$user->countAllJobsText().'.');
            }elseif (in_array($plan->id, ['growth-monthly-plan', 'growth-annual-plan']) && $user->countAllJobs() > 10) {
                throw IneligibleForPlan::because('Growth subscription limits you to only ten jobs. You currently have '.$user->countAllJobsText().'.');
            }

            return true;
        });
    }
}
