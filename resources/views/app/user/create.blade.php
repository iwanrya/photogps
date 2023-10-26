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
                    </ul>

                    <form method="POST" action="{{ url('/user') }}">
                        @csrf

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.username')}}</label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                                @if ($errors->has('username'))
                                <div>
                                    <small class="text-danger text-left">{{ $errors->first('username') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.name')}}</label>
                            <div class="col-12 col-sm-6 col-md-4">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <div>
                                    <small class="text-danger text-left">{{ $errors->first('name') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.email')}}</label>
                            <div class="col-12 col-sm-6 col-md-4">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                <div>
                                    <small class="text-danger text-left">{{ $errors->first('email') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.company')}}</label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <select name="company" class="form-control">
                                    <option></option>
                                    @foreach ($companies as $company)
                                    <option value="{{$company->code}}" {{ (old() && $company->code == old("company")) ? "selected" : "" }}>{{$company->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('company'))
                                <div>
                                    <small class="text-danger text-left">{{ $errors->first('company') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.role')}}</label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <select name="auth" class="form-control">
                                    <option></option>
                                    @foreach ($auths as $auth)
                                    <option value="{{$auth->id}}" {{ (old() && $auth->id == old("auth")) ? "selected" : "" }}>{{$auth->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('auth'))
                                <div>
                                    <small class="text-danger text-left">{{ $errors->first('auth') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.password')}}</label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                <div>
                                    <small class="text-danger text-left">{{ $errors->first('password') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.password_confirmation')}}</label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <input type="password" class="form-control" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                <div>
                                    <small class="text-danger text-left">{{ $errors->first('password_confirmation') }}</small>
                                </div>
                                @endif
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