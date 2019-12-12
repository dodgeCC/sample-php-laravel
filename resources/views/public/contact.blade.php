@extends('layouts.app')

@section('navbar-light', true)

@section('content')

<div class="container py-7">
	<div class="row mb-6">
		<div class="col-12">
			<h1 class="text-center font-weight-bold mb-4">Contact Us</h1>
			<p class="text-center font-weight-bold lead"></p>
			<div class="col-md-6">
			@if (session('status'))
			@include('shared.status')
			@else
			<form method="POST" action="{{ route('contact') }}">
				@csrf
				@honeypot
				<div class="form-group">
					<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Auth::check() ? Auth::user()->name  : old('name') }}" required autofocus placeholder="{{ __('Name') }}">
					@if ($errors->has('name'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('name') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Auth::check() ? Auth::user()->email : old('email') }}" required placeholder="{{ __('E-Mail Address') }}">
					@if ($errors->has('email'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus placeholder="{{ __('Phone') }}">
					@if ($errors->has('phone'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('phone') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group">
					<textarea name="message" class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" required placeholder="{{ __('Your Message') }}">{{ old('message') }}</textarea>
					@if ($errors->has('message'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('message') }}</strong>
					</span>
					@endif
				</div>	
				<div class="form-group mb-0">
					<button type="submit" class="btn btn-primary">
						{{ __('Send Message') }}
					</button>
				</div>
			</form>
			@endif
			</div>
		</div>
	</div>



</div>

@endsection
