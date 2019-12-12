@extends('spark::layouts.app')

@section('title', 'Profile')

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
            @include('candidate.components.side-nav')
        </div>
        <div class="col-md-9">
            <div class="card-deck mb-3">
	    <div class="card">
	        <div class="card-body">
	            <h5 class="card-title text-muted font-weight-bolder mb-0"><small>Jobs</small></h5>
	            <h3 class="mb-0"><small>{{ $jobs }}</small></h3>
	        </div>
	    </div>
	    <div class="card">
	        <div class="card-body">
	            <h5 class="card-title text-muted font-weight-bolder mb-0"><small>Applications</small></h5>
	            <h3 class="mb-0"><small>{{ $applications }}</small></h3>
	        </div>
	    </div>
	    <div class="card">
	        <div class="card-body">
	            <h5 class="card-title text-muted font-weight-bolder mb-0"><small>Saved Jobs</small></h5>
	            <h3 class="mb-0"><small>{{ $saved_jobs }}</small></h3>
	        </div>
	    </div>
	</div>
	@include('spark::settings.profile')
        </div>
    </div>
</div>
@endsection
