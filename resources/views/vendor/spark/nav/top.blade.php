<li class="nav-item">
    <a class="nav-link @if(View::hasSection('navbar-light')) text-reset @else text-white @endif" href="{{ route('jobs.index') }}">{{__('Jobs')}}</a>
</li>
<li class="nav-item">
    <a class="nav-link @if(View::hasSection('navbar-light')) text-reset @else text-white @endif" href="{{ route('pricing') }}">{{__('Pricing')}}</a>
</li>
<li class="nav-item">
    <a class="nav-link @if(View::hasSection('navbar-light')) text-reset @else text-white @endif" href="{{ route('candidates') }}">{{__('For Candidates')}}</a>
</li>
<li class="nav-item">
    <a class="nav-link @if(View::hasSection('navbar-light')) text-reset @else text-white @endif" href="{{ route('employers') }}">{{__('For Employers')}}</a>
</li>
<li class="nav-item">
    <a class="nav-link @if(View::hasSection('navbar-light')) text-reset @else text-white @endif" href="{{ route('about') }}">{{__('About')}}</a>
</li>
