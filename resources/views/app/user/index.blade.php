@extends('app/common/layout')

@section('content')

<div class="login-page">
    <div class="center border rounded px-3 py-3 mx-auto login-box">
        <h1>Login</h1>
        <form id="form" action="/login/check" method="POST">
            @csrf

            <div class="mt-3">
                <label for="username" class="form-label">ユーザーID (メールアドレス) <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}">
            </div>

            @if ($errors->has('username'))
            <div>
                <small class="text-danger text-left">{{ $errors->first('username') }}</small>
            </div>
            @endif
            <div class="mt-3">
                <label for="password" class="form-label">パスワード <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" value="{{ old('password') }}">
            </div>
            @if ($errors->has('password'))
            <div>
                <small class="text-danger text-left">{{ $errors->first('password') }}</small>
            </div>
            @endif
            <div class="mt-3">
                <input type="checkbox" class="label-remember" id="rememberMe" name="rememberMe" checked>
                <label for="rememberMe" class="label-remember">このログイン情報をブラウザに保存する</label>
            </div>
            @if ($errors->has('unmatched'))
            <div>
                <small class="text-danger text-left">{{ $errors->first('unmatched') }}</small>
            </div>
            @endif
            <div class="mt-3 d-grid">
                <button name="submit" type="submit" form="form" class="btn btn-primary">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection