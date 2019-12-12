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
                            <th scope="col">Description</th>
                            <th scope="col">City</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($jobs->isNotEmpty())
                        @foreach($jobs as $job)
                        <tr id="job-{{ $job->id }}">
                            <td>
                                <p class="mb-0">
                                @if($job->isLive())
                                <a href="{{ $job->getUrl() }}" target="__blank">{{ $job }}</a>
                                @else
                                {{ $job }}
                                @endif
                                </p>
                                <div class="">
                                    @if($job->isExpired())
                                    <job-refresh id="refresh_{{ $job->id }}" job="{{ $job->id }}" action="{{ route('company.jobs.refresh', ['job'=>$job]) }}"></job-refresh><a id="edit_{{ $job->id }}" class="text-body d-none" href="{{ route('company.jobs.edit', ['job'=>$job]) }}">Edit</a> |
                                    @else
                                    <a class="text-body" href="{{ route('company.jobs.show', ['job'=>$job]) }}">View</a> |
                                    <a class="text-body" href="{{ route('company.jobs.edit', ['job'=>$job]) }}">Edit</a> |
                                    @endif
                                    <job-delete job="{{ $job->id }}" action="{{ route('company.jobs.destroy', ['job'=>$job]) }}"></job-delete>
                                </div>
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
