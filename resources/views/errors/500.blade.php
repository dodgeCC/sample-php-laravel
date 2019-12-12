@extends('layouts.app')

@section('navbar-light', true)

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))

@section('content')
<div class="container py-7">
        <div class="row mb-6">
            <div class="col-12">
                 <h1 class="text-center font-weight-bold mb-4">500 Server Error</h1>
                 <p class="text-center font-weight-bold lead"></p>
            </div>
        </div>
    </div>
@endsection
