@extends('spark::layouts.app')

@section('title', 'Job Applications')

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
        	@include('admin.components.side-nav')
        </div>
        <div class="col-md-9">
            @include('shared.status')
            <div class="table-responsive bg-white">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Job</th>
                            <th scope="col">Candidate</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            <th scope="col">Messages</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($applications->isNotEmpty())
                        @foreach($applications as $application)
                        @php $job = $application->job @endphp
                        @php $user = $application->user @endphp
                        <tr id="application-{{ $application->id }}">
                            <td>
                                <p class="mb-0"><a href="{{ route('admin.jobs.show', ['job'=>$job]) }}">{{ $job }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0"><a href="{{ route('admin.users.show', ['user'=>$user]) }}">{{ $user }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $application->getStatus() }}</p>
                            </td>
                            <td>
                                <p class="mb-0"><small>Created</small></p>
                                <p class="mb-0">{{ $application->getCreated() }}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $application->messages()->count() }}</p>
                            </td>
                            <td>
                                <p class="mb-0"><a href="{{ route('admin.applications.show', ['application'=>$application]) }}" class="btn btn-primary btn-sm">View</a></p>
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
