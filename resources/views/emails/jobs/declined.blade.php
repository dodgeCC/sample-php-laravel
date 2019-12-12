@extends('layouts.email')

@section('content')
<p>Hi {{ $candidate }},</p>
<p>Your job application for the {{ $job_application->job }} job is unsuccessful on {{ $job_application->getUpdated() }}.</p>
@endsection
