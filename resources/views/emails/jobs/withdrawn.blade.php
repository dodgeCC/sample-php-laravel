@extends('layouts.email')

@section('content')
<p>Hi {{ $company }},</p>
<p>{{ $candidate }} has withdrawn from your {{ $job_application->job }} job on {{ $job_application->getUpdated() }}.</p>
@endsection
