<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Project</title>
    @stack('meta')
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row py-3">

           
           @yield('content')


        </div>
    </div>

    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/datepicker.min.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    @stack('custom-script')

</body>
</html>
