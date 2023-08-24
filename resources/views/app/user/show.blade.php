@extends('app/common/layout')

@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card card-white mt-2">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">{{ __('user.title')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">{{ __('button.hidden')}}</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('user') }}">{{ __('user.view_link')}}</a></li>
                        <li><a href="{{ URL::to('user/create') }}">{{ __('user.create_link')}}</a></li>
                    </ul>
                    <div class="jumbotron text-center">
                        <h2>{{ $user->name }}</h2>
                        <p>
                            <strong>{{ __('user.username')}}:</strong> {{ $user->username }}<br>
                            <strong>{{ __('user.email')}}:</strong> {{ $user->email }}<br>
                            <strong>{{ __('user.email_verified_at')}}:</strong> {{ $user->email_verified_at_formatted }}<br>
                            <strong>{{ __('user.company')}}:</strong> {{ $user->companyUser ? $user->companyUser->company->name : "-" }}<br>
                            <strong>{{ __('user.role')}}:</strong> {{ $user->companyUser ? $user->companyUser->userAuth->name : "-" }}<br>
                            <strong>Created Date Time:</strong> {{ $user->created_at_formatted }}<br>
                            <strong>Last Updated Date Time:</strong> {{ $user->updated_at_formatted }}<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection