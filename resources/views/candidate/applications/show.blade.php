@extends('spark::layouts.app')

@section('title', $application->job)

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
        	@include('candidate.components.side-nav')
        </div>
        <div class="col-md-9">
        	<div class="card card-default">
            <div class="card-header">
                <div>
                    {{ $application->job }}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                	<div class="col-md-3 text-center">
                        	<img src="{{ $company->photo_url }}" class="spark-profile-photo-xl mb-5" alt="{{ $company }}" />
                    	</div>

                	<div class="col-md-9">
                		<job-application-messages ref="vm_job_application_messages" action="{{ route('candidate.jobs.applications.message', ['application'=>$application]) }}" messages='{{ json_encode($application->getMessagesDetails()) }}' channel='messaging.{{ $application->id }}' user='{{ $company }}' :admin="false"></job-application-messages>
                	</div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
