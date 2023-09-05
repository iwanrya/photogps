<?php

namespace App\Http\Controllers\Api;

use App\Core\exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChangePasswordResource;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{

    function change(Request $request)
    {
        try {
            // define validation rules
            $validator = Validator::make(
                $request->all(),
                [
                    'password'       => ['required'],
                    'newpassword'    => ['required'],
                    'confirmpassword' => ['required'],
                ],
                [
                    'confirmpassword.same' => __("changepassword.newpassword_not_matched")
                ]
            );

            // check if validation fails
            if ($validator->fails()) {
                throw new BadRequestException($validator->errors());
            }


            // define validation rules
            $validator = Validator::make(
                $request->all(),
                [
                    'password'       => [new MatchOldPassword],
                    'confirmpassword' => ['same:newpassword'],
                ],
                [
                    'confirmpassword.same' => __("changepassword.newpassword_not_matched")
                ]
            );

            // check if validation fails
            if ($validator->fails()) {
                return response()->json(new ChangePasswordResource(false, $validator->errors()->first()));
            }

            $password = $request->get('password') ?: null;
            $newpassword = $request->get('newpassword') ?: null;
            $cofirmpassword = $request->get('confirmpassword') ?: null;

            User::find(auth()->user()->id)->update(['password' => Hash::make($newpassword)]);

            return response()->json(new ChangePasswordResource(true));
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new ChangePasswordResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new ChangePasswordResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
