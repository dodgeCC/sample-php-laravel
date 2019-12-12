<aside>
    <h3 class="nav-heading ">
        {{__('Settings')}}
    </h3>
    <ul class="nav flex-column mb-4 ">
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('company.index') }}">
                {{__('Profile')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('company.security') }}">
                {{__('Security')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('company.notifications.index') }}">
                {{__('Notifications')}}
            </a>
        </li>
    </ul>
    <h3 class="nav-heading ">
        {{__('Dashboard')}}
    </h3>
    <ul class="nav flex-column mb-4 ">
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('company.jobs.index') }}">
                {{__('Jobs')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('company.jobs.create') }}">
                {{__('Create Job')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('company.applications.index') }}">
                {{__('Applications')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('company.jobs.filled') }}">
                {{__('Filled Jobs')}}
            </a>
        </li>
    </ul>
</aside>
