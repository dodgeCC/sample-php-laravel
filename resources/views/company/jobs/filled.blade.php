@extends('spark::layouts.app')

@section('title', 'Filled Jobs')

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
                            <th scope="col">Applications</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($jobs->isNotEmpty())
                        @foreach($jobs as $job)
                        <tr id="job-{{ $job->id }}">
                            <td>
                                <p class="mb-0"><a href="{{ route('company.jobs.show', ['job'=>$job]) }}">{{ $job }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $job->job_applications()->count() }}</p>
                            </td>
                            <td>
                                <p class="mb-0"><small>Created</small></p>
                                <p class="mb-0">{{ $job->getCreated() }}</p>
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
