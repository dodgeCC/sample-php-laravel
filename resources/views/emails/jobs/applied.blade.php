@extends('layouts.email')

@section('content')
<p>Hi {{ $company }},</p>
<p>{{ $candidate }} applied to your {{ $job_application->job }} job on {{ $job_application->getCreated() }}.</p>
@endsection
