@extends('spark::layouts.app')

@section('title', $job)

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
                    {{ $job }}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="{{ $user->photo_url }}" class="spark-profile-photo-xl" alt="{{__('Profile Photo')}}" />
                    </div>
                    <div class="col-md-9">
                        <p>
                            <strong>{{__('City')}}:</strong> {{ $job->city }}
                        </p>
                        <p>
                            <strong>{{__('Address')}}:</strong> {{ $job->address }}
                        </p>
                        <p>
                            <strong>{{__('Type')}}:</strong> {{ $job->getType() }}
                        </p>
                        <p>
                            <strong>{{__('Status')}}:</strong> {{ $job->getStatus() }}
                        </p>
                        <p>
                            <strong>{{__('Contract')}}:</strong> {{ $job->getContract() }}
                        </p>
                        <p>
                            <strong>{{__('Published')}}:</strong> {{ $job->getCreatedDateText() }}
                        </p>
                        <p>
                            <strong>{{__('Description')}}:</strong> {!! nl2br($job->description) !!}
                        </p>
                        <p>
                            <strong>{{__('Applicants')}}:</strong> {{ $job->job_applications()->count() }}
                        </p>
                        @if($successful_applications->isNotEmpty())
                        <p>
                            <strong>{{__('Successful Applicants')}}:</strong>
                            <ul class="list-group">
                                @foreach($successful_applications as $application)
                                <li class="list-group-item">
                                    <p><a href="{{ route('company.applications.show', ['application'=>$application]) }}">{{ $application->user }}</a></p>
                                </li>
                                @endforeach
                            </ul>
                        </p>
                        @endif

                        @if($job->isLive())
                        <p><a href="{{ $job->getUrl() }}" target="__blank">View job</a></p>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
