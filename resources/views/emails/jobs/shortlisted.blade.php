@extends('layouts.email')

@section('content')
<p>Hi {{ $candidate }},</p>
<p>Your job application for the {{ $job_application->job }} job is shortlisted on {{ $job_application->getUpdated() }}.</p>
@endsection
