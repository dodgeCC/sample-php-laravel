@extends('spark::layouts.app')

@section('title', 'Edit Job')

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
            @include('company.components.side-nav')
        </div>
        <div class="col-md-9">
            @if($user->canCreateJobs())
            @include('shared.errors')
            <form action="{{ route('company.jobs.update', ['job'=>$job]) }}" method="POST">
                @method('PUT')
                @csrf
                @include('company.jobs.components.form')
            </form>
            @else
            <p>You need to be subscribed to edit jobs. <a href="/settings#/subscription">Subscribe</a> now.</p>
            @endif
        </div>
    </div>
</div>
@endsection
