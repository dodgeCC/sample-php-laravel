@extends('spark::layouts.app')

@section('title', $contact)

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
                    {{ $contact }}
                </div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-12">
                        <!-- Email Address -->
                        <p>
                            <strong>{{__('Email Address')}}:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        </p>

                        <!-- Phone -->
                        <p>
                            <strong>{{__('Phone')}}:</strong> {{ $contact->phone }}
                        </p>

                        <!-- Message -->
                        <p>
                            {!! nl2br($contact->message) !!}
                        </p>                        

                        

                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
