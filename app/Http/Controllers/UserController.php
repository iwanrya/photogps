<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use App\Models\UserAuth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the user
        $builder = User::with('companyUser')->with('companyUser.company')
            ->with('companyUser.userAuth');
        $users = $builder->orderBy('id', 'asc')->paginate(50)->withQueryString();
        // $users = User::paginate(50)->withQueryString();

        // load the view and pass the user
        return View::make('app.user.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // companies
        $companies = Company::select('id as code', 'name')->orderBy('name', 'asc')->get();
        $auths = UserAuth::orderBy('is_system_owner', 'desc')
            ->orderBy('name', 'asc')->get();

        return View::make('app.user.create')
            ->with('companies', $companies)
            ->with('auths', $auths);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            // define validation rules
            $validator = Validator::make(
                $request->all(),
                [
                    'username'              => [
                        'required',
                        'unique:users,username',
                    ],
                    'name'                  => 'required',
                    'email'                 => [
                        'required',
                        'unique:users,email',
                    ],
                    'company'               => 'required',
                    'auth'                  => 'required',
                    'password'              => 'min:6|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'min:6'
                ],
                [
                    'username.required' => __("user.username_required"),
                    'name.required' => __("user.name_required"),
                    'name.unique' => __("user.name_unique"),
                    'email.required' => __("user.email_required"),
                    'email.unique' => __("user.email_unique"),
                    'company.required' => __("user.company_required"),
                    'auth.required' => __("user.auth_required"),
                    'password.min' => __("user.password_min"),
                    'password.same' => __("user.password_same"),
                    'password_confirmation.min' => __("user.passwordconfirmation_min"),
                ]
            );

            // check if validation fails
            if ($validator->fails()) {
                return redirect()->to('user/create')
                    ->withErrors($validator)
                    ->withInput();
                die();
            }

            $username = $request->get('username') ?: null;
            $name = $request->get('name') ?: null;
            $email = $request->get('email') ?: null;
            $company = $request->get('company') ?: null;
            $auth = $request->get('auth') ?: null;
            $password = $request->get('password') ?: null;

            $current_user = Auth::user();

            $user = User::create([
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'email_verified_at' => now(),
                'password' => bcrypt($password),
                'create_user_id' => $current_user->id
            ]);

            CompanyUser::create([
                'user_id' => $user->id,
                'company_id' => $company,
                'auth' => $auth
            ]);

            // redirect
            Session::flash('message', 'Successfully created user!');
            return redirect()->to('user');
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return redirect()->to('user/create')
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get the user
        $user = User::with(['companyUser', 'companyUser.company', 'companyUser.userAuth'])
            ->find($id);

        // show the view and pass the user to it
        return View::make('app.user.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get the user
        $user = User::with(['companyUser', 'companyUser.company', 'companyUser.userAuth'])
            ->find($id);

        if (empty($user)) {
            return Redirect::to('user');
            die();
        }

        // companies
        $companies = Company::select('id as code', 'name')->orderBy('name', 'asc')->get();
        $auths = UserAuth::orderBy('is_system_owner', 'desc')
            ->orderBy('name', 'asc')->get();

        // show the edit form and pass the user
        return View::make('app.user.edit')
            ->with('user', $user)
            ->with('companies', $companies)
            ->with('auths', $auths)
            ->with('user_company_id', $user->companyUser ? ($user->companyUser->company ? $user->companyUser->company->id : null) : null)
            ->with('user_auth_id', $user->companyUser ? ($user->companyUser->userAuth ? $user->companyUser->userAuth->id : null) : null);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Value of User before update
            $user_now = User::find($id);

            $validator = Validator::make($request->all(), [
                'username'              => [
                    'required',
                    Rule::unique('users', 'username')->ignore($user_now->id),
                ],
                'name'                  => 'required',
                'email'                 => [
                    'required',
                    Rule::unique('users', 'email')->ignore($user_now->id),
                ],
                'company'               => 'required',
                'auth'                  => 'required',
            ]);

            // check if validation fails
            if ($validator->fails()) {
                return redirect()->to('user/' . $id . '/edit')
                    ->withErrors($validator)
                    ->withInput();
                die();
            }

            $username = $request->get('username') ?: null;
            $name = $request->get('name') ?: null;
            $email = $request->get('email') ?: null;
            $company = $request->get('company') ?: null;
            $auth = $request->get('auth') ?: null;

            // store
            $user = User::find($id);
            $user->name = $name;
            $user->email = $email;
            $user->username = $username;
            $user->save();

            // store user company &  user auth
            $companyUser = CompanyUser::where('user_id', $id)->get();

            if (count($companyUser) > 0) {
                CompanyUser::where('user_id', $id)
                    ->update([
                        'company_id' => $company,
                        'auth' => $auth
                    ]);
            } else {
                CompanyUser::create([
                    'user_id' => $id,
                    'company_id' => $company,
                    'auth' => $auth
                ]);
            }

            // redirect
            Session::flash('message', 'Successfully updated user!');
            return Redirect::to('user');
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return redirect()->to('user/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * Show the form for deleting the specified resource.
     */
    public function delete(string $id)
    {
        // get the user
        $user = User::find($id);

        if (empty($user)) {
            return Redirect::to('user');
            die();
        }

        // show the edit form and pass the user
        return View::make('app.user.delete')
            ->with('user', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the user!');
        return Redirect::to('user');
    }
}
