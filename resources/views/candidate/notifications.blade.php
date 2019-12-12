@extends('spark::layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
            @include('candidate.components.side-nav')
        </div>
        <div class="col-md-9">
	<user-settings settings='{{ $settings }}' action="{{ route('candidate.notifications.store') }}"></user-settings>
        </div>
    </div>
</div>
@endsection
