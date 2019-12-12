@extends('spark::layouts.app')

@section('title', 'Create Job')

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
            @include('company.components.side-nav')
        </div>
        <div class="col-md-9">
            @if($user->canCreateJobs())
            @if($user->canCreateMoreJobs())
            @include('shared.errors')
            <form action="{{ route('company.jobs.store') }}" method="POST">
                @csrf
                @include('company.jobs.components.form')
            </form>
            @else
            <p>You can only have a maximum of {{ $user->getSubscription()->countMaxJobsText() }} for this subscription plan.</p>
            <p>You may <a href="/settings#/subscription">upgrade</a> your subscription to create more jobs.</p>
            @endif
            @else
            <p>You need to be subscribed to create jobs. <a href="/settings#/subscription">Subscribe</a> now.</p>
            @endif
        </div>
    </div>
</div>
@endsection
