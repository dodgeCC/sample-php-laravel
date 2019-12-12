@extends('spark::layouts.app')

@section('title', 'Saved Jobs')

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
                            <th scope="col">Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($saved_jobs->isNotEmpty())
                        @foreach($saved_jobs as $saved)
                        @php $job = $saved->job @endphp
                        <tr id="saved-job-{{ $saved->id }}">
                            <td>
                                <p class="mb-0"><a href="{{ $job->getUrl() }}" target="__blank">{{ $job }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0"><small>Saved</small></p>
                                <p class="mb-0">{{ $saved->getCreated() }}</p>
                            </td>
                            <td>
                                    <job-save-delete action="{{ route('candidate.jobs.saved.destroy', ['saved'=>$saved]) }}" job='{{ $saved->id }}'></job-save-delete>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                @if($saved_jobs->isNotEmpty())
                <div class="ml-2">
                    {{ $saved_jobs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
