<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the project
        $project = Project::paginate(50)->withQueryString();

        // load the view and pass the project
        return View::make('app.project.index')
            ->with('projects', $project);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View::make('app.project.create');
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
                return redirect()->to('project/create')
                    ->withErrors($validator)
                    ->withInput();
                die();
            }

            $name = $request->get('name') ?: null;

            $user = Auth::user();

            $project = Project::create([
                'name' => $name,
                'create_user_id' => $user->id
            ]);

            // redirect
            Session::flash('message', 'Successfully created project!');
            return redirect()->to('project');
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return redirect()->to('project/create')
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get the project
        $project = Project::find($id);

        // show the view and pass the project to it
        return View::make('app.project.show')
            ->with('project', $project);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get the project
        $project = Project::find($id);

        if (empty($project)) {
            return Redirect::to('project');
            die();
        }

        // show the edit form and pass the project
        return View::make('app.project.edit')
            ->with('project', $project);
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
            return redirect()->to('project/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
            die();
        }

        $name = $request->get('name') ?: null;

        // store
        $project = Project::find($id);
        $project->name = $name;
        $project->save();

        // redirect
        Session::flash('message', 'Successfully updated project!');
        return Redirect::to('project');
    }

    /**
     * Show the form for deleting the specified resource.
     */
    public function delete(string $id)
    {
        // get the project
        $project = Project::find($id);

        if (empty($project)) {
            return Redirect::to('project');
            die();
        }

        // show the edit form and pass the project
        return View::make('app.project.delete')
            ->with('project', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);
        $project->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the project!');
        return Redirect::to('project');
    }
}
