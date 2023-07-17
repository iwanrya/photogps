<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <div class="dropdown">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="ddmenu" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Str::upper(__('menu.menu')) }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="ddmenu">
                <li><a class="dropdown-item" href="{{ url('/') }}">{{ __('menu.home') }}</a></li>
                <li><a class="dropdown-item" href="{{ url('/photo') }}">{{ __('menu.photo_sharing') }}</a></li>
            </ul>
        </div>
        <div class="d-flex">
            <a class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modal_user_info">{{ __('menu.user_info')}}</a>
            <a class="btn btn-light btn-sm" href="{{ url('/logout') }}">{{ __('menu.logout')}}</a>
        </div>
    </div>
</nav>