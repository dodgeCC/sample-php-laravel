@extends('spark::layouts.app')

@section('title', 'Subscriptions')

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
                            <th scope="col">ID</th>
                            <th scope="col">Company</th>
                            <th scope="col">Plan</th>
                            <th scope="col">Date</th>
                            <th scope="col">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($subscriptions->isNotEmpty())
                        @foreach($subscriptions as $subscription)
                        @php $user = $subscription->user @endphp
                        <tr>
                            <td>
                                <p class="mb-0"><a href="https://dashboard.stripe.com/test/subscriptions/{{ $subscription->stripe_id }}" target="__blank">{{ $subscription->stripe_id }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0"><a href="{{ route('admin.users.show', ['user'=>$user]) }}">{{ $user }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $subscription->stripe_plan }}</p>
                            </td>
                           <td>
                                <p class="mb-0">{{ $subscription->getCreated() }}</p>
                            </td>
                            <td>
                                <p class="mb-0">@php echo $subscription->active() ? '<span class="badge badge-success">&#10004;</span>':'<span class="badge badge-danger">&#10005;</span>'  @endphp</p>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                @if($subscriptions->isNotEmpty())
                <div class="ml-2">
                    {{ $subscriptions->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
