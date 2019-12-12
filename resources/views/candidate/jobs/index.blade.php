@extends('spark::layouts.app')

@section('title', 'Jobs')

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
        	@include('candidate.components.side-nav')
        </div>
        <div class="col-md-9">
            @include('shared.status')
            <div class="table-responsive bg-white">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Job</th>
                            <th scope="col">Description</th>
                            <th scope="col">City</th>
                            <th scope="col">Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($jobs->isNotEmpty())
                        @foreach($jobs as $job)
                        <tr id="job-{{ $job->id }}">
                            <td>
                                <p class="mb-0"><a href="{{ $job->getUrl() }}" target="__blank">{{ $job }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0">{!! $job->getExcerpt(100) !!}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $job->city }}</p>
                            </td>
                            <td>
                                <p class="mb-0"><small>Created</small></p>
                                <p class="mb-0">{{ $job->getCreated() }}</p>
                            </td>
                            <td>
                                    @if($job_application = $user->getJobApplication($job))
                                    <p class="lead text-center application-status-{{ $job_application->id }}">{{ $job_application->getStatus() }} {{ $job_application->getCreated() }}</p>
                                    @if($job_application->isWithdrawn())
                                        @if($job->isLive())
                                        <job-re-apply action="{{ route('candidate.jobs.applications.re-apply', ['application'=>$job_application]) }}" application='{{ $job_application->id }}'></job-re-apply>
                                        @endif
                                    @endif
                                    @else
                                    <job-apply action="{{ route('candidate.jobs.applications.store') }}" job='{{ $job->id }}'></job-apply>
                                    @endif

                                    @if($job_saved = $user->getJobSaved($job))
                                    <p class="lead text-center">SAVED</p>
                                    @else
                                    <job-save action="{{ route('candidate.jobs.saved.store') }}" job='{{ $job->id }}'></job-save>
                                    @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                @if($jobs->isNotEmpty())
                <div class="ml-2">
                    {{ $jobs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
