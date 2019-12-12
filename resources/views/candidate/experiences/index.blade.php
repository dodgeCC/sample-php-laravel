@extends('spark::layouts.app')

@section('title', 'Experiences')

@section('content')
<div class="spark-screen container">
	<div class="row">
		<div class="col-md-3">
			@include('candidate.components.side-nav')
		</div>
		<div class="col-md-9">
			<experiences action="{{ route('candidate.experiences.store') }}" experiences='{{ json_encode($experiences) }}'></experiences>
		</div>
	</div>
</div>
@endsection
