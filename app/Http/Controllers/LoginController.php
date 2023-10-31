<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    function index()
    {
        return view("app/user/login");
    }

    function check(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)) :
            return redirect()->to('login')
                ->withInput()
                ->withErrors(array('unmatched' => __('auth.failed')));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        if ($request->get('rememberMe')) {
            setcookie("username", $request->get('username'), time() + 999999999);
            setcookie("password", $request->get('password'), time() + 999999999);
            setcookie("rememberMe", $request->get('rememberMe'), time() + 999999999);
        } else {
            setcookie("username", "");
            setcookie("password", "");
            setcookie("rememberMe", "");
        }

        return $this->authenticated();
    }

    protected function authenticated()
    {
        return redirect()->intended();
    }
}
