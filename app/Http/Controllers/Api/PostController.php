<?php

namespace App\Http\Controllers\Api;

use App\Core\exceptions\BadRequestException;
use App\Core\general\image\AddExifToImage;
use App\Core\general\image\DuplicateImage;
use App\Core\general\image\ExifImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import Model "Post"
use App\Models\Post;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
use App\Models\PostComment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use DateTime;
use DateTimeZone;
use Exception;
use stdClass;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = Post::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $posts);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {

        try {

            //define validation rules
            $validator = Validator::make($request->all(), [
                'photo'             => 'required|image|mimes:jpeg,jpg|max:8000',
                'shoot_datetime'    => 'required',
                'separate_exif'     => 'required',
                // 'project_id'        => 'required',
                // 'customer_id'       => 'required',
                // 'status'            => 'required',
            ]);

            //check if validation fails
            if ($validator->fails()) {
                throw new BadRequestException($validator->errors());
            }

            $separate_exif = $request->post('separate_exif') === 'true';
            $lat = 0.0;
            $long = 0.0;


            if ($separate_exif) {
                $lat = $request->post('latitude');
                $long = $request->post('longitude');
            }

            $area_id = $request->post('area_id') ? trim($request->post('area_id')) : null;
            $project_id = $request->post('project_id') ? trim($request->post('project_id')) : null;
            $customer_id = $request->post('customer_id') ? trim($request->post('customer_id')) : null;
            $status = $request->post('status') ? trim($request->post('status')) : null;
            $comment = $request->post('comment') ? trim($request->post('comment')) : '';

            // convert shoot_datetime from timestamp (string) to DateTime
            $shoot_timestamp = (float)$request->post('shoot_datetime');
            $datetime = DateTime::createFromFormat('U.u', $shoot_timestamp);
            date_timezone_set($datetime, new DateTimeZone(date_default_timezone_get()));

            // upload original image
            $image = $request->file('photo');

            $upload_image_name = time() . '.' . $image->extension();

            $filepath = storage_path('app/private/posts/') . $upload_image_name;

            $image->storeAs('private/posts', $upload_image_name);

            // create photo with exif from external
            $this->save_photo($filepath, $separate_exif, $lat, $long);

            // extract exif data from original image
            $extracted_exif_data = $this->extract_exif_data($filepath);

            if ($extracted_exif_data) {
                DuplicateImage::duplicate_photo($filepath, $upload_image_name, $extracted_exif_data->rotation);

                $user = Auth::user();

                $post = Post::create([
                    'create_user_id' => $user->id,
                    'photographer' => $user->name,
                    'photographer_username' => $user->username,
                    'image' => $upload_image_name,
                    'shoot_datetime' => $datetime->format('Y-m-d H:i:s.u'),
                    'latitude' => $extracted_exif_data->latitude,
                    'longitude' => $extracted_exif_data->longitude,
                    'area_id' => $area_id,
                    'project_id' => $project_id,
                    'customer_id' => $customer_id,
                    'status' => $status
                ]);

                $post->hideInternalFields();

                if (!empty($comment)) {
                    $post_comment = PostComment::create([
                        'create_user_id' => $user->id,
                        'post_id' => $post->id,
                        'comment' => $comment,
                    ]);
                }
            } else {
                throw new BadRequestException("Can not extract exif information from image");
            }

            // //return response
            return response()->json(new PostResource(true, "Image successfully uploaded"), Response::HTTP_OK);
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new PostResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new PostResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function save_photo($filepath, $separate_exif, $lat, $long)
    {
        if ($separate_exif === true) {
            AddExifToImage::addGpsInfo($filepath, $filepath, $lat, $long);
        }
    }

    private function extract_exif_data($image)
    {
        if (1 === 1) {

            $geotag = ExifImage::get_image_location($image);
            $rotation = ExifImage::get_image_rotation($image) * -1;

            $exif_data = new stdClass();
            $exif_data->latitude = $geotag ? $geotag['latitude'] : 0.0;
            $exif_data->longitude = $geotag ? $geotag['longitude'] : 0.0;
            $exif_data->shoot_datetime = time();
            $exif_data->rotation = $rotation;

            return $exif_data;
        } else {
            return false;
        }
    }

    /**
     * show
     *
     * @param  Request $request
     * @return void
     */
    public function read(Request $request)
    {
        try {
            // define validation rules
            $validator = Validator::make($request->all(), []);

            // check if validation fails
            if ($validator->fails()) {
                throw new BadRequestException($validator->errors());
            }

            // get filters
            $photographers = $request->get('photographer') ?: [];
            $areas = $request->get('area') ?: [];
            $customers = $request->get('customer') ?: [];
            $projects = $request->get('project') ?: [];
            $status = $request->get('status') ?: [];
            $shoot_date_start = $request->get('shoot_date_start') ?: "";
            $shoot_date_end = $request->get('shoot_date_end') ?: "";
            $comment = $request->get('comment') ?: "";

            // get data rows
            $builder = Post::with('postComment');
            if (!empty($photographers)) {
                $builder->whereIn('create_user_id', $photographers);
            }

            if (!empty($areas)) {
                $builder->whereIn('area_id', $areas);
            }

            if (!empty($customers)) {
                $builder->whereIn('customer_id', $customers);
            }

            if (!empty($projects)) {
                $builder->whereIn('project_id', $projects);
            }

            if (!empty($status)) {
                $builder->whereIn('status', $status);
            }

            if (!empty($shoot_date_start)) {
                $builder->where('shoot_datetime', '>=', $shoot_date_start);
            }

            if (!empty($shoot_date_end)) {
                $builder->where('shoot_datetime', '<=', $shoot_date_end . ' 23:59:59.9999');
            }

            if (!empty($comment)) {
                $builder->whereRelation('postComment', 'comment', 'like', "%{$comment}%");
            }

            $posts = $builder->latest()->get();

            foreach ($posts as $post) {
                $post->hideInternalFields();

                foreach ($post->postComment as $comment) {
                    $comment->hideInternalFields();
                }
            }

            return new PostResource(true, '', $posts);
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new PostResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new PostResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * show
     *
     * @param  Request $request
     * @return void
     */
    public function read_one(Request $request)
    {

        try {
            //define validation rules
            $validator = Validator::make($request->all(), [
                'photo_mobile_id' => 'required',
            ]);

            //check if validation fails
            if ($validator->fails()) {
                throw new BadRequestException($validator->errors());
            }

            $post_id = $request->get('photo_mobile_id');

            //find post by image name
            $builder = Post::with(['postComment', 'area', 'customer', 'project', 'statusItem']);
            $post = $builder->find($post_id);

            if (!empty($post)) {
                $post->hideInternalFields();
            }

            if (!empty($post->area)) {
                $post->area->hideInternalFields();
            }

            if (!empty($post->customer)) {
                $post->customer->hideInternalFields();
            }
            
            if (!empty($post->project)) {
                $post->project->hideInternalFields();
            }

            if (!empty($post->statusItem)) {
                $post->statusItem->hideInternalFields();
            }

            //return single post as a resource
            return new PostResource(true, '', $post);
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new PostResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new PostResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * show
     *
     * @param  Request $request
     * @return void
     */
    public function delete(Request $request)
    {
        try {
            //define validation rules
            $validator = Validator::make($request->all(), [
                'photo_mobile_id' => 'required',
            ]);

            //check if validation fails
            if ($validator->fails()) {
                throw new BadRequestException($validator->errors());
            }

            $post_id = $request->get('photo_mobile_id');

            // delete the post using flag
            $post = Post::find($post_id);
            $post->delete();

            //return single post as a resource
            return new PostResource(true, 'データが削除されました。');
        } catch (BadRequestException $ex) {
            error_log($ex->getMessage());
            return response()->json(new PostResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            return response()->json(new PostResource(false, "Exception: " . $ex->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
