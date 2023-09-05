@extends('app/common/layout')

@section('content')

<div class="login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <!-- <div class="text-center">
                    <img src="http://153.126.176.74/autopart_newui/assets/resources/img/logo.png" alt="" height="36">
                </div> -->
                <div class="mt-20">
                    <h1>{{ __('changepassword.title')}}</h1>
                    <form id="form" action="{{ URL::to('changepassword/change') }}" method="POST">
                        @csrf

                        <div class="mt-3">
                            <label for="password" class="form-label">{{ __('changepassword.password')}} <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                        </div>

                        @if ($errors->has('password'))
                        <div>
                            <small class="text-danger text-left">{{ $errors->first('password') }}</small>
                        </div>
                        @endif
                        <div class="mt-3">
                            <label for="newpassword" class="form-label">{{ __('changepassword.newpassword')}} <span class="text-danger">*</span></label>
                            <input type="password" name="newpassword" class="form-control" value="{{ old('newpassword') }}">
                        </div>
                        @if ($errors->has('newpassword'))
                        <div>
                            <small class="text-danger text-left">{{ $errors->first('newpassword') }}</small>
                        </div>
                        @endif
                        <div class="mt-3">
                            <label for="confirmpassword" class="form-label">{{ __('changepassword.confirmpassword')}} <span class="text-danger">*</span></label>
                            <input type="password" name="confirmpassword" class="form-control" value="{{ old('confirmpassword') }}">
                        </div>
                        @if ($errors->has('confirmpassword'))
                        <div>
                            <small class="text-danger text-left">{{ $errors->first('confirmpassword') }}</small>
                        </div>
                        @endif
                        <div class="mt-3 d-grid">
                            <button name="submit" type="submit" form="form" class="btn btn-primary">{{ __('changepassword.submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection