<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the customer
        $customer = Customer::paginate(50)->withQueryString();

        // load the view and pass the customer
        return View::make('app.customer.index')
            ->with('customers', $customer);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View::make('app.customer.create');
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
                return redirect()->to('customer/create')
                    ->withErrors($validator)
                    ->withInput();
                die();
            }

            $name = $request->get('name') ?: null;

            $user = Auth::user();

            $customer = Customer::create([
                'name' => $name,
                'create_user_id' => $user->id
            ]);

            // redirect
            Session::flash('message', 'Successfully created customer!');
            return redirect()->to('customer');
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return redirect()->to('customer/create')
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get the customer
        $customer = Customer::find($id);

        // show the view and pass the customer to it
        return View::make('app.customer.show')
            ->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get the customer
        $customer = Customer::find($id);

        // show the edit form and pass the customer
        return View::make('app.customer.edit')
            ->with('customer', $customer);
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
            return redirect()->to('customer/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
            die();
        }

        $name = $request->get('name') ?: null;

        // store
        $customer = Customer::find($id);
        $customer->name = $name;
        $customer->save();

        // redirect
        Session::flash('message', 'Successfully updated customer!');
        return Redirect::to('customer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the customer!');
        return Redirect::to('customer');
    }
}
