<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>

    


        <header >
            @include('includes.admin_nav')
        </header>


    <div id="main" class="row">

            @yield('content')

    </div>

    <footer class="row">
        @include('includes.footer')
    </footer>


</body>
</html>