@extends('spark::layouts.app')

@section('title', 'Jobs')

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
                            <th scope="col">Company</th>
                            <th scope="col">Description</th>
                            <th scope="col">City</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($jobs->isNotEmpty())
                        @foreach($jobs as $job)
                        @php $user = $job->user @endphp
                        <tr id="job-{{ $job->id }}">
                            <td>
                                <p class="mb-0"><a href="{{ route('admin.jobs.show', ['job'=>$job]) }}">{{ $job }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0"><a href="{{ route('admin.users.show', ['user'=>$user]) }}">{{ $user }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0">{!! $job->getExcerpt(100) !!}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $job->city }}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $job->getType() }}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $job->getStatus() }}</p>
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
