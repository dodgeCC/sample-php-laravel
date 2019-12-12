@extends('layouts.app')

@section('navbar-light', true)

@section('content')

    <div class="container py-7">
        <div class="row mb-6">
            <div class="col-12">
                 <h1 class="text-center font-weight-bold mb-4">Flexible, Transparent Pricing</h1>
                 <p class="text-center font-weight-bold lead">Competitive, cost effective plans that enable you to hire at scale.</p>
            </div>
        </div>

        <pricing data="{{ json_encode(['Monthly'=>[59,199,799], 'Annually'=>[null,1990,7990]]) }}" mode='monthly' route="{{ route('register', ['role'=>'company']) }}"></pricing>

    </div>

@endsection
