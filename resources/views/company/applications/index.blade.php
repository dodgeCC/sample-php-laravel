@extends('spark::layouts.app')

@section('title', 'Jobs')

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
        	@include('company.components.side-nav')
        </div>
        <div class="col-md-9">
            @include('shared.status')
            <div class="table-responsive bg-white">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Job</th>
                            <th scope="col">Applicant</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($applications->isNotEmpty())
                        @foreach($applications as $application)
                        @php $job = $application->job @endphp
                        <tr id="application-{{ $application->id }}">
                            <td>
                                <p class="mb-0">
                                @if($job->isDeleted())
                                {{ $job }}
                                @else
                                <a href="{{ route('company.jobs.show', ['job'=>$job]) }}">{{ $job }}</a>
                                @endif
                                </p>
                            </td>
                            <td>
                                <p class="mb-0">
                                @if($application->isWithdrawn())
                                {{ $application->user }}
                                @else
                                <a href="{{ route('company.applications.show', ['application'=>$application]) }}">{{ $application->user }}</a>
                                @endif
                                </p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $application->getStatus() }}</p>
                            </td>
                            <td>
                                <p class="mb-0"><small>Created</small></p>
                                <p class="mb-0">{{ $application->getCreated() }}</p>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                @if($applications->isNotEmpty())
                <div class="ml-2">
                    {{ $applications->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
