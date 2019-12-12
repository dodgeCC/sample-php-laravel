@extends('spark::layouts.app')

@section('title', 'Security')

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
            @include('candidate.components.side-nav')
        </div>
        <div class="col-md-9">
	@include('spark::settings.security')
        </div>
    </div>
</div>
@endsection
