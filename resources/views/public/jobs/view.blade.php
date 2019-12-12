@extends('layouts.app')

@section('navbar-light', 'navbar-light')

@section('content')
    <div class="job-view">
        <div>
            <div>
                <div>
                    <div>
                        <img src="{{ $company->photo_url }}" alt="{{ $company }}" />
                    </div>
                </div>
            </div>
            <div>
                <h1 class="h4 font-weight-bold float-left mr-3 mb-4">{{ $job }}</h1><small class="mt-1 text-muted d-inline-block">posted {{ $job->getCreatedDateText() }}</small>
                <div class="clearfix mb-1"></div>
                <div class="row mb-3">
                    <div class="col-3">
                        <small>
                            <i class="material-icons text-primary mr-2 align-text-top notranslate">business</i>
                            <span class="text-muted font-weight-bold">{{ $company }}</span>
                        </small>
                    </div>
                    <div class="col-3">
                        <small>
                            <i class="material-icons text-primary mr-2 align-text-top notranslate">place</i>
                            <span class="text-muted font-weight-bold">{{ $job->city }}</span>
                        </small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <small>
                            <i class="material-icons text-primary mr-2 align-text-top notranslate">attach_money</i>
                            <span class="text-muted font-weight-bold">{{ $job->wage }}</span>
                        </small>
                    </div>
                    <div class="col-3">
                        <small>
                            <i class="material-icons text-primary mr-2 align-text-top notranslate">schedule</i>
                            <span class="text-muted font-weight-bold">{{ $job->getContract() }}</span>
                        </small>
                    </div>
                </div>
            </div>
            @if ($user && $user->isCandidate())
            <div class="col-md-2">
            @if($job_application = $user->getJobApplication($job))
            <p class="lead text-center application-status-{{ $job_application->id }}">{{ $job_application->getStatus() }} {{ $job_application->getCreated() }}</p>
            @if($job_application->isWithdrawn())
                @if($job->isLive())
                <job-re-apply action="{{ route('candidate.jobs.applications.re-apply', ['application'=>$job_application]) }}" application='{{ $job_application->id }}'></job-re-apply>
                @endif
            @endif
            @else
            <job-apply action="{{ route('candidate.jobs.applications.store') }}" job='{{ $job->id }}'></job-apply>
            @if($job_saved = $user->getJobSaved($job))
            <p class="lead text-center">SAVED {{ $job_saved->getCreated() }}</p>
            @else
            <job-save action="{{ route('candidate.jobs.saved.store') }}" job='{{ $job->id }}'></job-save>
            @endif
            @endif
            </div>
            @endif
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="h4 font-weight-bold mb-4">{{ $job }}</h2>
                <p>{!! nl2br($job->description) !!}</p>
                @if($other_jobs->isNotEmpty())
                <h2 class="h4 font-weight-bold mt-5 mb-4">More Jobs from {{ $company }}</h2>
                <div class="row">
                    <div class="col-8">
                    @foreach($other_jobs as $other_job)
                        <job-card-row job='{{ json_encode($other_job->getDetails()) }}' apply='{{ ($user && $user->isCandidate()) }}' application='{{ ($user && $user->isCandidate() && $application = $user->getJobApplication($other_job)) ? $application->getCreated() : null }}'></job-card-row>
                    @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

@endsection
