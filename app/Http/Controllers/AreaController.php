<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the area
        $area = Area::orderBy('id', 'asc')->paginate(50)->withQueryString();

        // load the view and pass the area
        return View::make('app.area.index')
            ->with('areas', $area);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View::make('app.area.create');
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
                    'name'       => ['required', 'unique:areas,name'],
                ],
                [
                    'name.required' => __("area.name_required"),
                    'name.unique' => __("area.name_unique"),
                ]
            );

            // check if validation fails
            if ($validator->fails()) {
                return redirect()->to('area/create')
                    ->withErrors($validator)
                    ->withInput();
                die();
            }

            $name = $request->get('name') ?: null;

            $current_user = Auth::user();

            $area = Area::create([
                'name' => $name,
                'create_user_id' => $current_user->id
            ]);

            // redirect
            Session::flash('message', 'Successfully created area!');
            return redirect()->to('area');
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return redirect()->to('area/create')
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get the area
        $area = Area::find($id);

        // show the view and pass the area to it
        return View::make('app.area.show')
            ->with('area', $area);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get the area
        $area = Area::find($id);

        // show the edit form and pass the area
        return View::make('app.area.edit')
            ->with('area', $area);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name'       => [
                'required',
                Rule::unique('areea', 'name')->ignore($id),
            ],
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return redirect()->to('area/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
            die();
        }

        $name = $request->get('name') ?: null;

        // store
        $area = Area::find($id);
        $area->name = $name;
        $area->save();

        // redirect
        Session::flash('message', 'Successfully updated area!');
        return Redirect::to('area');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $area = Area::find($id);
        $area->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the area!');
        return Redirect::to('area');
    }
}
