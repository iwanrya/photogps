<?php

namespace App\Http\Controllers\Api;

use App\Core\exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AccessTokenResource;
use App\Http\Resources\BaseResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class SessionController extends Controller
{

    function get_access_token(LoginRequest $request)
    {
        try {
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

            $current_user = Auth::user();

            $user = User::with('companyUser')->with('companyUser.company')
                ->with('companyUser.userAuth')
                ->find($current_user->id);

            $user->hideInternalFields();

            if (!empty($user->companyUser)) {
                $user->companyUser->hideInternalFields();

                if (!empty($user->companyUser->company)) {
                    $user->companyUser->company->hideInternalFields();
                }
                if (!empty($user->companyUser->userAuth)) {
                    $user->companyUser->userAuth->hideInternalFields();
                }
            }

            return response()->json(new AccessTokenResource(true, $token, '', array("user" => $user)));
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new AccessTokenResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new AccessTokenResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function login_as()
    {
        $current_user = Auth::user();

        return response()->json(new BaseResource(true, '', array("current_user" => $current_user)));
    }

    function logout()
    {
        Auth::logout();
        return response()->json(new BaseResource(true));
    }
}
