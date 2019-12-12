@extends('spark::layouts.app')

@section('title', 'Applications')

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
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($job_applications->isNotEmpty())
                        @foreach($job_applications as $job_application)
                        @php $job = $job_application->job @endphp
                        <tr id="job_application-{{ $job_application->id }}">
                            <td>
                                <p class="mb-0">
                                @if($job->isDeleted())
                                {{ $job }}
                                @else
                                <a href="{{ route('candidate.jobs.applications.show', ['job_application'=>$job_application]) }}">{{ $job }}</a>
                                @endif
                                </p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $job_application->getStatus() }}</p>
                            </td>
                            <td>
                                <p class="mb-0"><small>Submitted</small></p>
                                <p class="mb-0">{{ $job_application->getCreated() }}</p>
                            </td>
                            <td>
                                @if($job_application->isWithdrawn())
                                    @if($job->isLive())
                                    <job-re-apply action="{{ route('candidate.jobs.applications.re-apply', ['application'=>$job_application]) }}" application='{{ $job_application->id }}'></job-re-apply>
                                    @endif
                                @elseif(!$job_application->isDeclined())
                                    <job-application-withdraw action="{{ route('candidate.jobs.applications.withdraw', ['application'=>$job_application]) }}" application='{{ $job_application->id }}'></job-application-withdraw>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                @if($job_applications->isNotEmpty())
                <div class="ml-2">
                    {{ $job_applications->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
