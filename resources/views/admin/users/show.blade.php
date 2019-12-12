@extends('spark::layouts.app')

@section('title', $user)

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
        	@include('admin.components.side-nav')
        </div>
        <div class="col-md-9">
           <div class="card card-default">
            <div class="card-header">
                <div>
                    {{ $user }}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Profile Photo -->
                    <div class="col-md-3 text-center">
                        <img src="{{ $user->photo_url }}" class="spark-profile-photo-xl" alt="{{__('Profile Photo')}}" />
                    </div>

                    <div class="col-md-9">
                        <!-- Email Address -->
                        <p>
                            <strong>{{__('Email Address')}}:</strong> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        </p>

                        <!-- Joined Date -->
                        <p>
                            <strong>{{__('Joined')}}:</strong> {{ $user->getCreated() }}
                        </p>

                        <!-- Role -->
                        <p>
                            <strong>{{__('Role')}}:</strong> {{ $user->role }}
                        </p>

                        @if($user->address)
                        <p>
                            <strong>{{__('Address')}}:</strong> {{ $user->address }}
                        </p>
                        @endif

                        @if(false && $user->hasLocation())
                        <p>Coordinates:{{ $user->lon }} {{ $user->lat }}</p>
                        @endif

                        <!-- Subscription -->
                        @if($user->isCompany())
                        <p>
                            <strong>{{__('Subscription')}}:</strong>

                            <span>
                                {{ $user->subscribed() ? $user->getSubscription()->getPlan() : 'no subscription' }}
                            </span>
                        </p>
                        <p>
                            @php $live_jobs = $user->getLiveJobs() @endphp
                            <strong>{{__('Live Jobs')}}:</strong> {{ $live_jobs->count() }}

                           @if($live_jobs->isNotEmpty())
                            <ul class="list-group">
                                @foreach($live_jobs as $job)
                                <li class="list-group-item">
                                    <p><a href="{{ route('admin.jobs.show', ['job'=>$job]) }}">{{ $job }}</a></p>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </p>
                        <p>
                            <strong>{{__('Applicants')}}:</strong> {{ $user->getJobApplicants()->count() }}
                        </p>
                        <p>
                            <strong>{{__('Teams')}}:</strong> {{ $user->teams()->count() }}

                            @if($user->teams->isNotEmpty())
                            <ul class="list-group">
                                @foreach($user->teams as $team)
                                <li class="list-group-item">
                                    <p><a href="{{ route('admin.teams.show', ['team'=>$team]) }}">{{ $team }}</a> @if($team->owner_id==$user->id) (owner) @endif</p>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </p>
                        @elseif($user->isCandidate())
                        <p>
                            <strong>{{__('Applications')}}:</strong>

                            <span>
                                {{ $user->job_applications()->count() }}
                            </span>
                        </p>
                        @php
                        $experiences = $user->experiences()->orderBy('start', 'desc')->get();
                        $skills = $user->skills()->orderBy('years', 'desc')->orderBy('months', 'desc')->get();
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
