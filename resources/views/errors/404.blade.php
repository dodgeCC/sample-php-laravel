@extends('layouts.app')

@section('navbar-light', true)

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))

@section('content')
<div class="container py-7">
        <div class="row mb-6">
            <div class="col-12">
                 <h1 class="text-center font-weight-bold mb-4">404 Not Found</h1>
                 <p class="text-center font-weight-bold lead"></p>
            </div>
        </div>
    </div>
@endsection
