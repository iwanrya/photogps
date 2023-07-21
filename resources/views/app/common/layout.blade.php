<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Photo GPS</title>

    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet" type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
    <link href="{{asset('css/bootstrap-multiselect.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
    <link href="{{asset('plugins/timepicker/css/jquery.timepicker.min.css')}}" rel="stylesheet" />

    @yield('css')
</head>

<body>
    @auth
    @include('app/common/header')
    @endauth

    <div class="d-flex justify-content-center container">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    @include('app/common/footer')

    @stack('js')

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('plugins/timepicker/js/jquery.timepicker.min.js')}}"></script>
    <script src="{{asset('js/app/text_formating.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>

    @yield('js')

    @auth
    @include('app/common/modal_user_info')
    @endauth
</body>

</html>