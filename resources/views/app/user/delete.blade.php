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

                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="mb-5">
                            @csrf
                            @method('DELETE')

                            <div class="col-12">
                                <h4>{{ __('user.delete_confirmation')}}</h4>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('app.yes')}}</button>
                                <a href="{{ URL::to('user') }}" class="btn btn-sm btn-success">{{ __('app.no')}}</a>
                            </div>

                        </form>

                        <h2>{{ $user->name }}</h2>
                        <p>
                            <strong>{{ __('user.created_datetime')}}:</strong> {{ $user->created_at_formatted }}<br>
                            <strong>{{ __('user.last_updated_datetime')}}:</strong> {{ $user->updated_at_formatted }}<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection