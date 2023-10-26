<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the company
        $company = Company::hideHidden()->paginate(50)->withQueryString();

        // load the view and pass the company
        return View::make('app.company.index')
            ->with('companys', $company);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View::make('app.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            // define validation rules
            $validator = Validator::make($request->all(), [
                'name'       => 'required',
            ]);

            // check if validation fails
            if ($validator->fails()) {
                return redirect()->to('company/create')
                    ->withErrors($validator)
                    ->withInput();
                die();
            }

            $name = $request->get('name') ?: null;
            $is_system_owner = $request->get('is_system_owner') ? true : false;

            $user = Auth::user();

            $company = Company::create([
                'name' => $name,
                'is_system_owner' => $is_system_owner,
                'create_user_id' => $user->id
            ]);

            // redirect
            Session::flash('message', 'Successfully created company!');
            return redirect()->to('company');
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return redirect()->to('company/create')
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get the company
        $company = Company::hideHidden()->findOrFail($id);

        // show the view and pass the company to it
        return View::make('app.company.show')
            ->with('company', $company);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get the company
        $company = Company::with('companyUser')->with('companyUser.userAuth')->find($id);

        // show the edit form and pass the company
        return View::make('app.company.edit')
            ->with('company', $company);
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
            return redirect()->to('company/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
            die();
        }

        $name = $request->get('name') ?: null;
        $is_system_owner = $request->get('is_system_owner') ? true : false;

        // store
        $company = Company::findOrFail($id);
        $company->name = $name;
        $company->is_system_owner = $is_system_owner;
        $company->save();

        // redirect
        Session::flash('message', 'Successfully updated company!');
        return Redirect::to('company');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the company!');
        return Redirect::to('company');
    }
}
