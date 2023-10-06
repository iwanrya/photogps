<?php

namespace App\Http\Controllers\Api;

use App\Core\exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCommentResource;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    public function read(Request $request)
    {
        try {

            //define validation rules
            $validator = Validator::make($request->all(), [
                'photo_mobile_id' => 'required'
            ]);

            //check if validation fails
            if ($validator->fails()) {
                throw new BadRequestException($validator->errors());
            }

            $post_id = $request->get('photo_mobile_id');

            $post_comments = PostComment::with('createUser')->where('post_id', $post_id)->get();

            return new PostCommentResource(true, '', $post_comments);
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new PostCommentResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new PostCommentResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function insert(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'photo_mobile_id' => 'required',
            'comment' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            throw new BadRequestException($validator->errors());
        }

        $post_id = (int) $request->post('photo_mobile_id');
        $comment = $request->post('comment');
        
        $user = Auth::user();

        $post_comments = PostComment::create([
            'post_id' => $post_id,
            'comment' => $comment,
            'create_user_id' => $user->id
        ]);

        return new PostCommentResource(true, '', $post_comments);
    }
}
