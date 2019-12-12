@extends('spark::layouts.app')

@section('title', 'Plans')

@section('content')
<div class="spark-screen container">
    <div class="row">
        <div class="col-md-3">
        	@include('admin.components.side-nav')
        </div>
        <div class="col-md-9">
            @include('shared.status')
            <div class="table-responsive bg-white">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Plan</th>
                            <th scope="col">ID</th>
                            <th scope="col">Price</th>
                            <th scope="col">Active</th>
                            <th scope="col">Subscriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($plans->isNotEmpty())
                        @foreach($plans as $plan)
                        <tr>
                            <td>
                                <p class="mb-0">{{ $plan->name }}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $plan->id }}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $currency_symbol.$plan->price.'/'.$plan->interval }}</p>
                            </td>
                            <td>
                                <p class="mb-0">@php echo $plan->active ? '<span class="badge badge-success">&#10004;</span>':'<span class="badge badge-danger">&#10005;</span>'  @endphp</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $plan->subscriptions }}</p>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
