<aside>
    <h3 class="nav-heading ">
        {{__('Settings')}}
    </h3>
    <ul class="nav flex-column mb-4 ">
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('candidate.index') }}">
                {{__('Profile')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('candidate.security') }}">
                {{__('Security')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('candidate.notifications.index') }}">
                {{__('Notifications')}}
            </a>
        </li>
    </ul>
    <h3 class="nav-heading ">
        {{__('Dashboard')}}
    </h3>
    <ul class="nav flex-column mb-4 ">
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('candidate.jobs.index') }}">
                {{__('Jobs')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('candidate.jobs.applications.index') }}">
                {{__('Applications')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('candidate.jobs.saved.index') }}">
                {{__('Saved Jobs')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('candidate.experiences.index') }}">
                {{__('Experiences')}}
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('candidate.skills.index') }}">
                {{__('Skills')}}
            </a>
        </li>
    </ul>
</aside>
