<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Material+Icons' rel='stylesheet' type='text/css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    
    <link rel="preconnect" href="//apis.google.com">
    <link rel="preconnect" href="//www.googletagmanager.com">
    <link rel="preconnect" href="//www.google-analytics.com">
    <link rel="preconnect" href="//www.google.co.uk">
    <link rel="preconnect" href="//www.google.com">

    <link rel="dns-prefetch" href="//apis.google.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link rel="dns-prefetch" href="//www.google.co.uk">
    <link rel="dns-prefetch" href="//www.google.com">
    
    <link rel="preload" href="/fonts/open-sans-regular.woff2" as="font" type="font/woff2" crossorigin>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ mix(Spark::usesRightToLeftTheme() ? 'css/app-rtl.css' : 'css/app.css') }}">

    <!-- Scripts -->
    @stack('scripts')

    <!-- Global Spark Object -->
    <script>
        window.Spark = <?php echo json_encode(array_merge(Spark::scriptVariables(), [])); ?>;
    </script>
</head>
<body>
    <div id="spark-app" v-cloak>
        <!-- Navigation -->
        @if (Auth::check())
            @include('spark::nav.front-user')
        @else
            @include('spark::nav.guest')
        @endif

        <!-- Main Content -->
        
            @yield('content')
        

        <!-- Application Level Modals -->
        @if (Auth::check())
            @include('spark::modals.notifications')
            @include('spark::modals.support')
            @include('spark::modals.session-expired')
        @endif
    </div>
    
    @include('components.footer')

    <!-- JavaScript -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="/js/sweetalert.min.js"></script>
</body>
</html>
