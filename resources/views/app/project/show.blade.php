@extends('app/common/layout')

@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card card-white mt-2">
                <div class="card-header">
                    <h3 class="card-title with-left-border text-bold">{{ __('project.title')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-show-hide" data-card-widget="collapse">
                            <i class="fa fa-minus"> <span class="sh-text">{{ __('button.hidden')}}</span></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('project') }}">{{ __('project.view_link')}}</a></li>
                        <li><a href="{{ URL::to('project/create') }}">{{ __('project.create_link')}}</a></li>
                    </ul>
                    <div class="jumbotron text-center">
                        <h2>{{ $project->name }}</h2>
                        <p>
                            <strong>{{ __('project.created_datetime')}}:</strong> {{ $project->created_at_formatted }}<br>
                            <strong>{{ __('project.last_updated_datetime')}}:</strong> {{ $project->updated_at_formatted }}<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection