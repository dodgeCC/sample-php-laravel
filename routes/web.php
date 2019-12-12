<?php
use Spatie\Honeypot\ProtectAgainstSpam;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/pricing', 'HomeController@pricing')->name('pricing');
Route::get('/candidates', 'HomeController@candidates')->name('candidates');
Route::get('/employers', 'HomeController@employers')->name('employers');
Route::match(['get', 'post'], '/contact', 'HomeController@contact')->name('contact')->middleware(ProtectAgainstSpam::class);
Route::get('/investors', 'HomeController@investors')->name('investors');
Route::get('/careers', 'HomeController@careers')->name('careers');
Route::get('/press', 'HomeController@press')->name('press');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/how-to-submit-a-job', 'HomeController@howToSubmitAJob')->name('job-submit-how');
Route::get('/profile-best-practices', 'HomeController@profileBestPractices')->name('profile-best-practices');

Route::name('jobs.')->prefix('tech-jobs')->group(function () {
    Route::get('/', 'JobsController@index')->name('index');
    Route::post('/search', 'JobsController@search')->name('search');
    Route::get('/{location}/{role}/{id}', 'JobsController@view')->name('view');
    Route::get('/{location}/{role}/{id}/apply', 'JobsController@apply')->name('apply');
    Route::get('/{search}/{location}', 'JobsController@topSearch')->name('top-search');
});

Route::get('/dashboard', 'HomeController@dashboard');

Route::get('/register/{role}', '\Laravel\Spark\Http\Controllers\Auth\RegisterController@showRegistrationForm')->where('role', '(candidate|company)')->name('register');

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', 'Admin\HomeController@index')->name('index');
    Route::get('/security', 'Admin\HomeController@security')->name('security');

    Route::resources([
        'users' => 'Admin\UserController'
    ]);
    Route::get('/candidates', 'Admin\UserController@candidates')->name('users.candidates');
    Route::get('/companies', 'Admin\UserController@companies')->name('users.companies');

    Route::resources([
        'jobs' => 'Admin\JobController'
    ]);

    Route::resources([
        'applications' => 'Admin\JobApplicationController'
    ]);
    Route::post('applications/message/{application}', 'Admin\JobApplicationController@message')->name('applications.message');

    Route::get('/plans', 'Admin\PlanController@index')->name('plans.index');
    Route::get('/subscriptions', 'Admin\PlanController@subscriptions')->name('subscriptions.index');
    Route::get('/teams', 'Admin\PlanController@teams')->name('teams.index');
    Route::get('/teams/{team}', 'Admin\PlanController@showTeam')->name('teams.show');

    Route::resources([
        'contacts' => 'Admin\ContactController'
    ]);
});

Route::middleware(['auth', 'candidate', 'verified'])->name('candidate.')->prefix('candidate')->group(function () {
    Route::get('/', 'Candidate\HomeController@index')->name('index');
    Route::get('/security', 'Candidate\HomeController@security')->name('security');
    
    Route::name('jobs.')->prefix('jobs')->group(function () {
        Route::get('/', 'Candidate\JobController@index')->name('index');

        Route::resources([
            'applications' => 'Candidate\JobApplicationController'
        ]);
        Route::put('applications/withdraw/{application}', 'Candidate\JobApplicationController@withdraw')->name('applications.withdraw');
        Route::put('applications/re-apply/{application}', 'Candidate\JobApplicationController@reApply')->name('applications.re-apply');
        Route::post('applications/message/{application}', 'Candidate\JobApplicationController@message')->name('applications.message');

        Route::resources([
            'saved' => 'Candidate\JobSaveController'
        ]);
    });

    Route::resources([
        'experiences' => 'Candidate\ExperienceController'
    ]);

    Route::resources([
        'skills' => 'Candidate\SkillController'
    ]);

    Route::resources([
            'notifications' => 'Candidate\SettingController'
        ]);
});

Route::middleware(['auth', 'company', 'verified'])->name('company.')->prefix('company')->group(function () {
    Route::get('/', 'Company\HomeController@index')->name('index');
    Route::get('/security', 'Company\HomeController@security')->name('security');

    Route::get('jobs/filled', 'Company\JobController@filled')->name('jobs.filled');
    Route::resources([
        'jobs' => 'Company\JobController'
    ]);
    Route::put('jobs/refresh/{job}', 'Company\JobController@refresh')->name('jobs.refresh');

    Route::resources([
        'applications' => 'Company\JobApplicationController'
    ]);
    Route::put('applications/process/{application}', 'Company\JobApplicationController@process')->name('applications.process');
    Route::post('applications/message/{application}', 'Company\JobApplicationController@message')->name('applications.message');

    Route::resources([
            'notifications' => 'Company\SettingController'
        ]);
});

Route::middleware(['auth', 'verified'])->name('settings.')->prefix('settings')->group(function () {
    Route::put('/profile/address', 'SettingsController@updateAddress');
});

Route::post('cities', 'HomeController@cities')->name('cities');
