<div class="form-group">
	<label for="title">Title</label>
	<input type="text" class="form-control" name="title" value="{{ isset($job) ? old('title', $job->title) : old('title') }}">
</div>
<div class="form-group">
	<label for="description">Description</label>
	<textarea class="form-control" name="description" rows="5">{{ isset($job) ? old('description', $job->description) : old('description') }}</textarea>
</div>
<div class="form-group">
	<label for="type">Type</label>
	<select name="type" class="form-control">
		@foreach ($job_types as $key => $type)
		@if(old('type') == $key || isset($job) && old('type', $job->type) == $key)
		<option value="{{ $key }}" selected>{{ $type }}</option>
		@else
		<option value="{{ $key }}">{{ $type }}</option>
		@endif
		@endforeach
	</select>
</div>
<country-city-select countries='{{ $countries }}' country_id='{{ isset($job) ? old('country_id', $job->getCountryId()) : old('country_id') }}' cities='{{ $cities }}' city_id='{{ isset($job) ? old('city_id', $job->city_id) : old('city_id') }}' cities_route="{{ route('cities') }}"></country-city-select>
<div class="form-group">
	<label for="address">Address</label>
	<input type="text" class="form-control" name="address" value="{{ isset($job) ? old('address', $job->address) : old('address') }}">
</div>
<div class="form-group">
	<label for="wage">Wage</label>
	<input type="number" min="0" class="form-control" name="wage" value="{{ isset($job) ? old('wage', $job->wage) : old('wage') }}">
</div>
<div class="form-group">
	<label for="contract_length">Contract Length</label>
	<input type="number" min="0" max="100" class="form-control" name="contract_length" value="{{ isset($job) ? old('contract_length', $job->contract_length) : old('contract_length') }}">
</div>
<div class="form-group">
	<label for="contract_interval">Contract Interval</label>
	<select name="contract_interval" class="form-control">
		@foreach ($job_contract_intervals as $key => $interval)
		@if(old('contract_interval') == $key || isset($job) && old('contract_interval', $job->contract_interval) == $key)
		<option value="{{ $key }}" selected>{{ $interval }}</option>
		@else
		<option value="{{ $key }}">{{ $interval }}</option>
		@endif
		@endforeach
	</select>
</div>
<div class="form-group">
	@if(isset($job))
	<input type="submit" class="btn btn-sm btn-link mr-3" value="Save" name="save">
	@if($job->isDraft())
	<input type="submit" class="btn btn-sm btn-primary" value="Publish" name="publish">
	@else
	<input type="submit" class="btn btn-sm btn-primary" value="Unpublish" name="unpublish">
	@endif
	@else
	<input type="submit" class="btn btn-sm btn-link mr-3" value="Save Draft" name="draft">
	<input type="submit" class="btn btn-sm btn-primary" value="Publish" name="publish">
	@endif
</div>
