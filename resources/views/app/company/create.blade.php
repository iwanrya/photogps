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
                    </ul>

                    <form method="POST" action="{{ url('/company') }}">
                        @csrf

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-4 col-md-3 col-lg-2 text-right xs-text-left">{{ __('company.name')}}</label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <div>
                                    <small class="text-danger text-left">{{ $errors->first('name') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-4 col-md-3 col-lg-2 text-right xs-text-left"></label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_system_owner" id="is_system_owner" value="1" {{ old('is_system_owner') ? "checked" : "" }}>
                                    <label class="form-check-label" for="is_system_owner">
                                        {{ __('user_auth.system_owner')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">{{ __('button.submit')}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection