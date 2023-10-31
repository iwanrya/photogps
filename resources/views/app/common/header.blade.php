<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <div class="dropdown">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="ddmenu" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Str::upper(__('menu.menu')) }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="ddmenu">
                <li><a class="dropdown-item" href="{{ url('/photo') }}">{{ __('menu.photo_sharing') }}</a></li>
                @if (Auth::user()->isSystemOwner())
                <li><a class="dropdown-item" href="{{ url('/project') }}">{{ __('menu.project') }}</a></li>
                <li><a class="dropdown-item" href="{{ url('/area') }}">{{ __('menu.area') }}</a></li>
                <li><a class="dropdown-item" href="{{ url('/user') }}">{{ __('menu.user') }}</a></li>
                <li><a class="dropdown-item" href="{{ url('/user_auth') }}">{{ __('menu.user_auth') }}</a></li>
                <li><a class="dropdown-item" href="{{ url('/company') }}">{{ __('menu.company') }}</a></li>
                @endif
            </ul>
        </div>
        {{ __('app.name') }}
        <div class="d-flex">
            <a class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modal_user_info">{{ __('menu.user_info')}}</a>
            <a class="btn btn-light btn-sm" href="{{ url('/logout') }}">{{ __('menu.logout')}}</a>
        </div>
    </div>
</nav>