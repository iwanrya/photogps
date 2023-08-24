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

                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.username')}}</label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <input type="text" class="form-control" name="username" value="{{ $user->username }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.name')}}</label>
                            <div class="col-12 col-sm-6 col-md-4">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.email')}}</label>
                            <div class="col-12 col-sm-6 col-md-4">
                                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.company')}}</label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <select name="company" class="form-control" value="{{ $user->companyUser ? $user->companyUser->company->name : '-' }}">
                                    <option></option>
                                    @foreach ($companys as $company)
                                    <option value="{{$company->id}}" {{( $user->companyUser && $user->companyUser->company->id == $company->id) ? "selected" : "" }}>{{$company->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-12 col-sm-5 col-md-4 col-lg-3 text-right xs-text-left">{{ __('user.role')}}</label>
                            <div class="col-12 col-sm-5 col-md-3">
                                <select name="auth" class="form-control" value="{{ $user->companyUser ? $user->companyUser->userAuth->name : '-' }}">
                                    <option></option>
                                    @foreach ($auths as $auth)
                                    <option value="{{$auth->id}}" {{( $user->companyUser && $user->companyUser->userAuth->id == $auth->id) ? "selected" : "" }}>{{$auth->name}}</option>
                                    @endforeach
                                </select>
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