<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\MatchOldPassword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{

    function index()
    {
        return view("app/user/changepassword");
    }

    function change(Request $request)
    {
        try {
            // define validation rules
            $validator = Validator::make(
                $request->all(),
                [
                    'password'       => ['required', new MatchOldPassword],
                    'newpassword'    => 'min:6|required_with:confirmpassword|same:confirmpassword',
                    'confirmpassword' => 'min:6',
                ],
                [
                    'password.required' => __("changepassword.oldpassword_required"),
                    'newpassword.required' => __("changepassword.newpassword_required"),
                    'newpassword.required' => __("changepassword.newpasswordconfirmation_required"),
                    'newpassword.same' => __("changepassword.newpassword_not_matched"),
                    'newpassword.min' => __("user.password_min"),
                    'confirmpassword.min' => __("user.passwordconfirmation_min"),
                ]
            );

            // check if validation fails
            if ($validator->fails()) {
                return redirect()->to('changepassword')
                    ->withErrors($validator)
                    ->withInput();
                die();
            }

            $password = $request->get('password') ?: null;
            $newpassword = $request->get('newpassword') ?: null;
            $cofirmpassword = $request->get('confirmpassword') ?: null;

            User::find(auth()->user()->id)->update(['password' => Hash::make($newpassword)]);

            // redirect
            Session::flash('message', 'Successfully change password!');
            return redirect()->to('home');
        } catch (Exception $ex) {
            echo $ex->getMessage();
            die();
            error_log($ex->getMessage());
            return redirect()->to('changepassword/change')
                ->withErrors($validator)
                ->withInput();
        }
    }
}
