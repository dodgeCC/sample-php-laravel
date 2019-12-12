@extends('layouts.app')


@section('content')
    <div class="bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-white text-center font-weight-bold mb-4">Your next role…</h1>
                    <p class="text-center text-white lead mb-5">The next gen recruitment platform is here…</p>
                    <form action="{{ route('jobs.search') }}" method="POST" class="form-inline mx-auto w-75">
                        @csrf
                        <input type="hidden" name="route" value="home">
                        <div class="form-control-container">
                            <input type="text" name="jobs_search" value="{{ $search }}" class="border-0" id="inlineFormInputGroupUsername2" placeholder="e.g. Web developer London" data-lpignore="true">
                            <button type="submit" class="btn btn-primary mb-2">SEARCH</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-6">
        <div class="row">
        @if($jobs->isNotEmpty())
        @foreach($jobs as $job)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <job-card job='{{ json_encode($job->getDetails()) }}'></job-card>
        </div>
        @endforeach
        @endif
        </div>
        @if($jobs->isNotEmpty())
        <div class="ml-2">
            {{ $jobs->links() }}
        </div>
        @endif
    </div>
@endsection
