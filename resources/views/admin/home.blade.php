@extends('spark::layouts.app')

@section('title', 'Profile')

@section('content')
<div class="spark-screen container">
	<div class="row">
		<div class="col-md-3">
			@include('admin.components.side-nav')
		</div>
		<div class="col-md-9">
			<div class="card-deck mb-3">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title text-muted font-weight-bolder mb-0"><small>Users</small></h5>
						<h3 class="mb-0"><small>{{ $users }}</small></h3>
					</div>
				</div>
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
			</div>
			<div class="card-deck mb-3">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title text-muted font-weight-bolder mb-0"><small>Plans</small></h5>
						<h3 class="mb-0"><small>{{ $plans }}</small></h3>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title text-muted font-weight-bolder mb-0"><small>Subscriptions</small></h5>
						<h3 class="mb-0"><small>{{ $subscriptions }}</small></h3>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title text-muted font-weight-bolder mb-0"><small>Teams</small></h5>
						<h3 class="mb-0"><small>{{ $teams }}</small></h3>
					</div>
				</div>
			</div>
			@include('spark::settings.profile')
		</div>
	</div>
</div>
@endsection
