@extends('spark::layouts.app')

@section('title', $role)

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
                            <th scope="col"></th>
                            <th scope="col">Name</th>
                            <!-- <th scope="col">Role</th> -->
                            <th scope="col">Email</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($users->isNotEmpty())
                        @foreach($users as $user)
                        <tr id="user-{{ $user->id }}">
                            <td>
                                <img src="{{ $user->photo_url }}" alt="{{ $user }}" class="spark-nav-profile-photo"/>
                            </td>
                            <td>
                                <p class="mb-0"><a href="{{ route('admin.users.show', ['user'=>$user]) }}">{{ $user }}</a></p>
                            </td>
                            <!-- <td>
                                <p class="mb-0">{{ $user->role }}</p>
                            </td> -->
                            <td>
                                <p class="mb-0">{{ $user->email }}</p>
                            </td>
                            <td>
                                <p class="mb-0"><small>Created</small></p>
                                <p class="mb-0">{{ $user->getCreated() }}</p>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                @if($users->isNotEmpty())
                <div class="ml-2">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
