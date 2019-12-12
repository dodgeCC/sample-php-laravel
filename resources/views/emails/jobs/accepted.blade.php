@extends('layouts.email')

@section('content')
<p>Hi {{ $candidate }},</p>
<p>Congratulations! Your job application for the {{ $job_application->job }} job is successful on {{ $job_application->getUpdated() }}.</p>
@endsection
