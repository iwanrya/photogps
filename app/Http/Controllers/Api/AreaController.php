<?php

namespace App\Http\Controllers\Api;

use App\Core\exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;
use App\Models\Area;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
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

            $areas = Area::select('id', 'name')->get();

            //return single post as a resource
            return new AreaResource(true, '', $areas->makeHidden(['created_at_formatted', 'updated_at_formatted']));
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new AreaResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new AreaResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
