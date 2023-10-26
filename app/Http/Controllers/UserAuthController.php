<?php

namespace App\Http\Controllers;

use App\Models\UserAuth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class UserAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the user_auth
        $user_auth = UserAuth::orderBy('id', 'asc')->paginate(50)->withQueryString();

        // load the view and pass the user auth
        return View::make('app.user_auth.index')
            ->with('user_auths', $user_auth);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View::make('app.user_auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            // define validation rules
            $validator = Validator::make($request->all(), [
                'name'                  => 'required',
            ]);

            // check if validation fails
            if ($validator->fails()) {
                return redirect()->to('user_auth/create')
                    ->withErrors($validator)
                    ->withInput();
                die();
            }

            $name = $request->get('name') ?: null;
            $is_system_owner = $request->get('is_system_owner') ? true : false;

            $current_user = Auth::user();

            $user_auth = UserAuth::create([
                'name' => $name,
                'is_system_owner' => $is_system_owner,
                'create_user_id' => $current_user->id
            ]);

            // redirect
            Session::flash('message', 'Successfully created user auth!');
            return redirect()->to('user_auth');
        } catch (Exception $ex) {
            print($ex->getMessage());
            error_log($ex->getMessage());
            return redirect()->to('user_auth/create')
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get the user_auth
        $user_auth = UserAuth::find($id);

        // show the view and pass the user_auth to it
        return View::make('app.user_auth.show')
            ->with('user_auth', $user_auth);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get the user_auth
        $user_auth = UserAuth::find($id);

        // show the edit form and pass the user_auth
        return View::make('app.user_auth.edit')
            ->with('user_auth', $user_auth);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return redirect()->to('user_auth/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
            die();
        }

        $name = $request->get('name') ?: null;
        $is_system_owner = $request->get('is_system_owner') ? true : false;

        // store
        $user_auth = UserAuth::find($id);
        $user_auth->name = $name;
        $user_auth->is_system_owner = $is_system_owner;
        $user_auth->save();

        // redirect
        Session::flash('message', 'Successfully updated user auth!');
        return Redirect::to('user_auth');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_auth = UserAuth::find($id);
        $user_auth->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the user auth!');
        return Redirect::to('user_auth');
    }
}
