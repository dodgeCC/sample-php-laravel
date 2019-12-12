<aside>
    <h3 class="nav-heading ">
        {{__('Settings')}}
    </h3>
    <ul class="nav flex-column mb-4 ">
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.index') }}">
                {{__('Profile')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.security') }}">
                {{__('Security')}}
            </a>
        </li>
    </ul>
    <h3 class="nav-heading ">
        {{__('Dashboard')}}
    </h3>
    <ul class="nav flex-column mb-4 ">
        <!-- <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                {{__('Users')}}
            </a>
        </li> -->
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.users.companies') }}">
                {{__('Companies')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.teams.index') }}">
                {{__('Teams')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.users.candidates') }}">
                {{__('Candidates')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.jobs.index') }}">
                {{__('Jobs')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.applications.index') }}">
                {{__('Applications')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.plans.index') }}">
                {{__('Plans')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.subscriptions.index') }}">
                {{__('Subscriptions')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                {{__('Contacts')}}
            </a>
        </li>
    </ul>
</aside>
