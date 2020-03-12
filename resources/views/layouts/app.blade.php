<head>
    @include("includes.head")
    <title>RayaEx | @yield('page')</title>
</head>
<body>
    @include("includes.header")
    @yield('content')
    <script src="/js/jquery.min.js"></script>
    @yield('footer')
    @include("includes.footer")
</body>