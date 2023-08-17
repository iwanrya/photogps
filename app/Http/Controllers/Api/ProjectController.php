<?php

namespace App\Http\Controllers\Api;

use App\Core\exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * show
     *
     * @param  Request $request
     * @return void
     */
    public function dropdown(Request $request)
    {

        try {
            // define validation rules
            $validator = Validator::make($request->all(), []);

            // check if validation fails
            if ($validator->fails()) {
                throw new BadRequestException($validator->errors());
            }

            $current_user = Auth::user();

            $user = User::with(['companyUser', 'companyUser.company', 'companyUser.userAuth'])
                ->find($current_user->id);

            $builder = Project::select('id', 'name', 'company_id')->orderBy('name', 'asc');

            if ($user->companyUser->userAuth->is_system_owner == false) {
                $builder->where('company_id', '=', $user->companyUser->company_id);
            }

            $projects = $builder->get();

            //return single post as a resource
            return new ProjectResource(true, '', $projects->makeHidden(['created_at_formatted', 'updated_at_formatted']));
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new ProjectResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new ProjectResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
