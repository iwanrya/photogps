<?php

namespace App\Http\Controllers\Api;

use App\Core\exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhotographerResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PhotographerController extends Controller
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

            $builder = User::select('id', 'name')->with(['companyUser']);

            if ($user->companyUser->userAuth->is_system_owner == false) {
                $builder->whereRelation('companyUser', 'company_id', '=', $user->companyUser->company_id);
            }

            $users = $builder->orderBy('name', 'asc')->get();

            //return single post as a resource
            return new PhotographerResource(true, '', $users->makeHidden(['created_at_formatted', 'updated_at_formatted']));
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new PhotographerResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new PhotographerResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
