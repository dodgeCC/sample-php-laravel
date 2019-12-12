@extends('layouts.email')

@section('content')
<p>Hi {{ $company }},</p>
<p>Your "{{ $job }}" job has expired.</p>
@endsection
