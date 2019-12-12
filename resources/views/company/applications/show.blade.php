@extends('spark::layouts.app')

@section('title', $candidate)

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
        	@include('company.components.side-nav')
        </div>
        <div class="col-md-9">
        <div class="card card-default">
            <div class="card-header">
                <div>
                    {{ $candidate }}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Profile Photo -->
                    <div class="col-md-3 text-center">
                        <img src="{{ $candidate->photo_url }}" class="spark-profile-photo-xl mb-5" alt="{{ $candidate }}" />
                        <job-application-process action="{{ route('company.applications.process', ['application'=>$application]) }}" application='{{ $application->id }}' status='{{ $application->status }}' filled='{{ $application->job->isFilled() }}'></job-application-process>
                    </div>

                    <div class="col-md-9">
                        <!-- Joined Date -->
                        <p>
                            <strong>{{__('Joined')}}:</strong> {{ $candidate->getCreated() }}
                        </p>

                        @if($candidate->address)
                        <p>
                            <strong>{{__('Address')}}:</strong> {{ $candidate->address }}
                        </p>
                        @endif

                        @php
                        $experiences = $candidate->experiences()->orderBy('start', 'desc')->get();
                        $skills = $candidate->skills()->orderBy('years', 'desc')->orderBy('months', 'desc')->get();
                        @endphp
                        @if($experiences->isNotEmpty())
                        <p>
                            <strong>{{__('Experiences')}}:</strong>

                            <ul class="list-group">
                                @foreach($experiences as $experience)
                                <li class="list-group-item">
                                    <p>{{ $experience }} - {{ $experience->company }}</p>
                                    <p>{{ $experience->description }}</p>
                                    <p>{{ $experience->getInterval() }}</p>
                                </li>
                                @endforeach
                            </ul>
                        </p>
                        @endif
                        @if($skills->isNotEmpty())
                        <p>
                            <strong>{{__('Skills')}}:</strong>

                            <ul class="list-group">
                                @foreach($skills as $skill)
                                <li class="list-group-item">
                                    <p>{{ $skill }} - {{ $skill->getInterval() }}</p>
                                </li>
                                @endforeach
                            </ul>
                        </p>
                        @endif
                        <job-application-messages ref="vm_job_application_messages" action="{{ route('company.applications.message', ['application'=>$application]) }}" messages='{{ json_encode($application->getMessagesDetails()) }}' channel='messaging.{{ $application->id }}' user='{{ $candidate }}' :admin="false"></job-application-messages>
                    </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
