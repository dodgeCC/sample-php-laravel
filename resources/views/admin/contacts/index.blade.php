@extends('spark::layouts.app')

@section('title', 'Contacts')

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
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Message</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($contacts->isNotEmpty())
                        @foreach($contacts as $contact)
                        <tr id="contact-{{ $contact->id }}">
                            <td>
                                <p class="mb-0">{{ $contact }}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $contact->email }}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $contact->phone }}</p>
                            </td>
                            <td>
                                <p class="mb-0"><a href="{{ route('admin.contacts.show', ['contact'=>$contact]) }}">{!! $contact->getExcerpt(50) !!}</a></p>
                            </td>
                            <td>
                                <p class="mb-0"><small>Created</small></p>
                                <p class="mb-0">{{ $contact->getCreated() }}</p>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                @if($contacts->isNotEmpty())
                <div class="ml-2">
                    {{ $contacts->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
