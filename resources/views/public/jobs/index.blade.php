@extends('layouts.app')

@section('navbar-light', 'navbar-light')

@section('content')
    <div class="container pt-7 pb-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center font-weight-bold mb-4">Jobs Search</h1>
            </div>
        </div>
    </div>

    <div class="container py-6">
        <div class="row">
            <div class="col-3">
            <form action="{{ route('jobs.search') }}" method="POST">
                        @csrf
                        <input type="hidden" name="route" value="jobs.index">
                <div class="form-group">
                    <input type="text" name="jobs_search" value="{{ $search }}" class="form-control" placeholder="Search">
                </div>
                <h6 class="font-weight-bold mb-3">Work Type</h6>
                <div class="form-group">
                    @foreach($job_types as $key => $job_type)
                    @if($key)
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" name="types[]" value="{{ $key }}" class="custom-control-input" id="customCheck{{ $key }}"@if($job_types_selected && in_array($key, $job_types_selected)) checked @endif>
                        <label class="custom-control-label" for="customCheck{{ $key }}">{{ $job_type }}</label>
                    </div>
                    @endif
                    @endforeach
                </div>
                <h6 class="font-weight-bold mb-3">Location</h6>
                <div class="form-group">
                    <input type="text" name="jobs_location" value="{{ $location }}" class="form-control" placeholder="e.g. W11 or West London">
                </div>
                @if (Auth::check() && Auth::user()->hasLocation())
                <h6 class="font-weight-bold mb-3">Within</h6>
                <job-location-range within='{{ $within }}' ></job-location-range>
                @endif
                <div class="form-group">
                    <button type="submit" class="btn btn-primary mt-5">SEARCH</button>
                </div>
                </form>
            </div>
            <div class="col-8 offset-1">
                @if($jobs->isNotEmpty())
                @foreach($jobs as $job)
                <job-card job='{{ json_encode($job->getDetails()) }}'></job-card>
                @endforeach
                <div class="ml-2">
                    {{ $jobs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
