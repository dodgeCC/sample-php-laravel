<nav class="navbar @yield('navbar-light', 'navbar-dark') navbar-expand-md navbar-spark fixed-top position-absolute py-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <svg width="56px" height="53px" viewBox="0 0 56 53" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-150.000000, -20.000000)" fill="@if(View::hasSection('navbar-light')) #414141 @else #ffffff @endif" fill-rule="nonzero">
                        <g transform="translate(150.000000, 20.000000)">
                            <path d="M41.8459467,39.2095791 C38.6011419,47.2945355 30.8276813,53 21.7323601,53 C9.71173363,53 0,43.0342697 0,30.7807692 C0,18.5272688 9.71173363,8.56153846 21.7323601,8.56153846 C30.2721794,8.56153846 37.646674,13.5913567 41.2014637,20.8979653 L48.6910425,2.38560479 C49.4846819,0.423927002 51.7007408,-0.515768573 53.6407484,0.286735975 C55.580756,1.08924052 56.510071,3.33005305 55.7164315,5.29173083 L41.9172301,39.0631132 C41.893719,39.1127469 41.8699568,39.161567 41.8459467,39.2095791 Z M21.7323601,45.3381963 C29.5052494,45.3381963 35.8393307,38.8384561 35.8393307,30.7807692 C35.8393307,22.7230824 29.5052494,16.2233422 21.7323601,16.2233422 C13.9594708,16.2233422 7.62538951,22.7230824 7.62538951,30.7807692 C7.62538951,38.8384561 13.9594708,45.3381963 21.7323601,45.3381963 Z"></path>
                        </g>
                    </g>
                </g>
            </svg>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                @include('spark::nav.top')
                <li class="nav-item">
                    <a class="nav-link @if(View::hasSection('navbar-light')) text-reset @else text-white @endif" href="{{ route(Auth::user()->getDashboardRoute()) }}">{{__('Dashboard')}}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
