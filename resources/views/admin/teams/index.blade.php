@extends('spark::layouts.app')

@section('title', 'Teams')

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
                            <th scope="col">Owner</th>
                            <th scope="col">Members</th>
                            <th scope="col">Invitations</th>
                            <th scope="col">Date</th>
                            <th scope="col">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($teams->isNotEmpty())
                        @foreach($teams as $team)
                        @php $user = $team->owner @endphp
                        <tr>
                            <td>
                                <img src="{{ $team->photo_url }}" alt="{{ $team }}" class="spark-nav-profile-photo"/>
                            </td>
                            <td>
                                <p class="mb-0"><a href="{{ route('admin.teams.show', ['team'=>$team]) }}">{{ $team }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0"><a href="{{ route('admin.users.show', ['user'=>$user]) }}">{{ $user }}</a></p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $team->users()->count() }}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $team->invitations()->count() }}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $team->getCreated() }}</p>
                            </td>
                            <td>
                                <p class="mb-0">@php echo $team->isActive() ? '<span class="badge badge-success">&#10004;</span>':'<span class="badge badge-danger">&#10005;</span>'  @endphp</p>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                @if($teams->isNotEmpty())
                <div class="ml-2">
                    {{ $teams->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
