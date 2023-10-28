<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
    public function index(Request $request)
    {
        $current_user = Auth::user();

        // get filters
        $filter_companies = $request->get('company') ?: [];
        $filter_name = $request->get('name') ?: "";

        $builder = Project::read($current_user, $filter_companies, $filter_name);

        $projects = $builder->orderBy('id', 'asc')->paginate(50)->withQueryString();

        // companies
        $companies = Company::select('id as code', 'name')->where('is_system_owner', false)->orderBy('name', 'asc')->get();

        // load the view and pass the project
        return View::make('app.project.index')
            ->with('projects', $projects)
            ->with('companies', $companies);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // companies
        $companies = Company::select('id as code', 'name')->where('is_system_owner', false)->orderBy('name', 'asc')->get();

        return View::make('app.project.create')
            ->with('companies', $companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            // define validation rules
            $validator = Validator::make($request->all(), [
                'company'    => 'required',
                'name'       => 'required',
            ],
            [
                'company.required' => __("project.company_required"),
                'name.required' => __("project.name_required"),
            ]);

            // check if validation fails
            if ($validator->fails()) {
                return redirect()->to('project/create')
                    ->withErrors($validator)
                    ->withInput();
                die();
            }

            $company = $request->get('company') ?: null;
            $name = $request->get('name') ?: null;

            $current_user = Auth::user();

            $project = Project::create([
                'company_id' => $company,
                'name' => $name,
                'create_user_id' => $current_user->id
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

        // companies
        $companies = Company::select('id as code', 'name')->where('is_system_owner', false)->orderBy('name', 'asc')->get();

        // show the edit form and pass the project
        return View::make('app.project.edit')
            ->with('project', $project)
            ->with('companies', $companies);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'company'    => 'required',
            'name'       => 'required',
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return redirect()->to('project/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
            die();
        }

        $company = $request->get('company') ?: null;
        $name = $request->get('name') ?: null;

        // store
        $project = Project::find($id);
        $project->company_id = $company;
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
