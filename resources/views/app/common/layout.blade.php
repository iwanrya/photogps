<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Photo GPS</title>

    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet" type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
    <link href="{{asset('assets/css/bootstrap-multiselect.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
    <link href="{{asset('assets/plugins/timepicker/css/jquery.timepicker.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />

    @stack('css')
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

    @stack('modals')
    @auth
    @include('app/common/modal_user_info')
    @include('app/common/custom_alert')
    @endauth

    <?php
    function return_bytes($size_str)
    {
        switch (substr($size_str, -1)) {
            case 'M':
            case 'm':
                return (int)$size_str * 1048576;
            case 'K':
            case 'k':
                return (int)$size_str * 1024;
            case 'G':
            case 'g':
                return (int)$size_str * 1073741824;
            default:
                return $size_str;
        }
    }
    ?>

    <script>
        const base_url = "<?= url('/') . '/'; ?>";
        const current_page = location.href.replace(location.search, '');
        const up_ms = "<?= return_bytes(ini_get('upload_max_filesize')); ?>";
        const up_ms_text = "<?= ini_get('upload_max_filesize') . 'B'; ?>";
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="{{asset('assets/js/bootstrap-multiselect.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('assets/plugins/timepicker/js/jquery.timepicker.min.js')}}"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script src="{{asset('assets/js/app/text_formating.js')}}"></script>
    <script src="{{asset('assets/js/app/loading.js')}}"></script>
    <script src="{{asset('assets/js/app/paging.js')}}"></script>
    <script src="{{asset('assets/js/app/url.js')}}"></script>
    <script src="{{asset('assets/js/app/list_api.js')}}"></script>
    <script src="{{asset('assets/js/app/custom_alert.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>

    @stack('js')
</body>

</html>