@extends('layouts.app')

@section('navbar-light', 'navbar-light')

@section('content')
    @php
        $job = array(
            'company' => 'ETCH',
            'role' => 'Senior SEO Manager',
            'wage' => 'BOE',
            'location' => 'London',
            'type' => 'Full-time'
        )
    @endphp
    <div class="container pt-7 pb-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center font-weight-bold mb-4">Tech Jobs Search</h1>
            </div>
        </div>
    </div>

    <div class="container py-6">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <h6 class="font-weight-bold mb-3">Work Type</h6>
                <div class="form-group">
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Permanent</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2">Internship</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="customCheck3">
                        <label class="custom-control-label" for="customCheck3">Part-time</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="customCheck4">
                        <label class="custom-control-label" for="customCheck4">Contract</label>
                    </div>
                </div>
                <h6 class="font-weight-bold mb-3">Location</h6>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="e.g. W11 or West London">
                </div>
                <h6 class="font-weight-bold mb-3">Within</h6>
                <div class="form-group">
                    <input type="range" class="form-control-range" id="formControlRange">
                </div>
            </div>
            <div class="col-8 offset-1">
                <job-card-row :job='{{ json_encode($job) }}'></job-card-row>
                <job-card-row :job='{{ json_encode($job) }}'></job-card-row>
                <job-card-row :job='{{ json_encode($job) }}'></job-card-row>
                <job-card-row :job='{{ json_encode($job) }}'></job-card-row>
            </div>
        </div>
    </div>
@endsection