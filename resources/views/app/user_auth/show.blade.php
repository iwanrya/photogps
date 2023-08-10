@extends('app/common/layout')

@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card card-white mt-2">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">{{ __('user_auth.title')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">{{ __('button.hidden')}}</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('user_auth') }}">{{ __('user_auth.view_link')}}</a></li>
                        <li><a href="{{ URL::to('user_auth/create') }}">{{ __('user_auth.create_link')}}</a></li>
                    </ul>
                    <div class="jumbotron text-center">
                        <h2>{{ $user_auth->name }}</h2>
                        <p>
                            <strong>System Owner:</strong> {{ $user_auth->is_system_owner ? __('app.yes') : __('app.no') }}<br>
                            <strong>Created Date Time:</strong> {{ $user_auth->created_at_formatted }}<br>
                            <strong>Last Updated Date Time:</strong> {{ $user_auth->updated_at_formatted }}<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection