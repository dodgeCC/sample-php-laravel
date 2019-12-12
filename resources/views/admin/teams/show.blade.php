@extends('spark::layouts.app')

@section('title', $team)

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
                    {{ $team }}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="{{ $team->photo_url }}" class="spark-profile-photo-xl" alt="{{__('Profile Photo')}}" />
                    </div>
                    <div class="col-md-9">
                        <p>
                            <strong>{{__('Owner')}}:</strong> <a href="{{ route('admin.users.show', ['user'=>$user]) }}">{{ $team->owner }}</a>
                        </p>

                        <p>
                            <strong>{{__('Created')}}:</strong> {{ $team->getCreated() }}
                        </p>
                        
                        <p>
                            <strong>{{__('Members')}}:</strong> {{ $team->users()->count() }}

                            @if($team->users->isNotEmpty())
                            <ul class="list-group">
                                @foreach($team->users as $member)
                                <li class="list-group-item">
                                    <p><a href="{{ route('admin.users.show', ['user'=>$member]) }}">{{ $member }}</a> @if($team->owner_id==$member->id) (owner) @endif</p>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </p>
                        
                        <p>
                            <strong>{{__('Invitations')}}:</strong> {{ $team->invitations()->count() }}
                        </p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
