@extends('spark::layouts.app')

@section('title', 'Skills')

@section('content')
<div class="spark-screen container">
	<div class="row">
		<div class="col-md-3">
			@include('candidate.components.side-nav')
		</div>
		<div class="col-md-9">
			<skills action="{{ route('candidate.skills.store') }}" skills='{{ json_encode($skills) }}'></skills>
		</div>
	</div>
</div>
@endsection
