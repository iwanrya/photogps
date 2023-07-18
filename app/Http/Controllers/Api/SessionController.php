<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AccessTokenResource;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class SessionController extends Controller
{

    function get_access_token(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return response()->json(new AccessTokenResource(false, null, 'Username password does not match / not exist'));
        }

        $payload = array(
            'username' => $request->post('username'),
            'password' => $request->post('password'),
        );
        $token = JWTAuth::claims($payload)->attempt($credentials);

        return response()->json(new AccessTokenResource(true, $token));
    }

    function login_as()
    {
        $user = Auth::user();

        return response()->json(new BaseResource(true, '', array("current_user" => $user)));
    }

    function logout()
    {
        Auth::logout();
        return response()->json(new BaseResource(true));
    }
}
