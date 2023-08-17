<?php

namespace App\Http\Controllers\Api;

use App\Core\exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
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

            $customers = Company::select('id', 'name')->where('is_system_owner', false)->orderBy('name', 'asc')->get();

            //return single post as a resource
            return new CustomerResource(true, '', $customers->makeHidden(['created_at_formatted', 'updated_at_formatted']));
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new CustomerResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new CustomerResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
