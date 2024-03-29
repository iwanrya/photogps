@extends('app/common/layout')

@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card card-white mt-2">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">{{ __('company.title')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">{{ __('button.hidden')}}</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('company') }}">{{ __('company.view_link')}}</a></li>
                        <li><a href="{{ URL::to('company/create') }}">{{ __('company.create_link')}}</a></li>
                    </ul>
                    <div class="jumbotron text-center">
                        <h2>{{ $company->name }}</h2>
                        <p>
                            <strong>{{ __('company.system_owner')}}:</strong> {{ $company->is_system_owner ? __('app.yes') : __('app.no') }}<br>
                            <strong>{{ __('company.created_datetime')}}:</strong> {{ $company->created_at_formatted }}<br>
                            <strong>{{ __('company.last_updated_datetime')}}:</strong> {{ $company->updated_at_formatted }}<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection