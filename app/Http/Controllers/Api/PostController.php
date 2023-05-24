<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import Model "Post"
use App\Models\Post;

//import Resource "PostResource"
use App\Http\Resources\PostResource;

//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

use Image;

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
                'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8000',
            ]);

            //check if validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            //upload original image
            $image = $request->file('image');

            $upload_image_name = time().'.'.$image->extension();

            $image->storeAs('private/posts', $upload_image_name);

            $geotag = $this->get_image_location($image);
            $rotation = $this->get_image_rotation($image);

            $post = Post::create([
                'image' => $upload_image_name,
                'latitude' => $geotag ? $geotag['latitude'] : 0.0,
                'longitude' => $geotag ? $geotag['longitude'] : 0.0
            ]);

            // create public image
            $public_path = storage_path('app/public/posts/');

            Image::configure(['driver' => 'imagick']);

            $img = Image::make($image->path());
            $img->rotate($rotation);
            $img->save($public_path . $upload_image_name);

            // create public thumbnail
            $public_thumbnail_path = storage_path('app/public/thumbnail/posts/');

            $img = Image::make($image->path());
            $img->rotate($rotation);
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($public_thumbnail_path . $upload_image_name);

            //return response
            return new PostResource(true, 'Image successfully uploaded', $post);
        } catch (Exception $ex) {
            return response("Exception: " . $ex->getMessage());
        }

    }

    private function get_image_location($image = ''){
        $exif = exif_read_data($image, 0, true);
        if($exif && isset($exif['GPS'])){
            $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude    = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef= $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude   = $exif['GPS']['GPSLongitude'];
            
            $lat_degrees = count($GPSLatitude) > 0 ? $this->gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes = count($GPSLatitude) > 1 ? $this->gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds = count($GPSLatitude) > 2 ? $this->gps2Num($GPSLatitude[2]) : 0;
            
            $lon_degrees = count($GPSLongitude) > 0 ? $this->gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes = count($GPSLongitude) > 1 ? $this->gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds = count($GPSLongitude) > 2 ? $this->gps2Num($GPSLongitude[2]) : 0;
            
            $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;
            
            $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60*60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60*60)));
    
            return array('latitude'=>$latitude, 'longitude'=>$longitude);
        }else{
            return false;
        }
    }

    private function get_image_rotation($image = ''){
        $exif = exif_read_data($image, 0, true);

        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3:
                    return 180;
                
                case 6:
                    return 90;
                
                case 8:
                    return -90;
            }
        }

        return 0;

    }

    private function gps2Num($coordPart){
        $parts = explode('/', $coordPart);
        if(count($parts) <= 0)
        return 0;
        if(count($parts) == 1)
        return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($image_name)
    {
        //find post by image name
        $post = Post::where('image', $image_name)->get();

        //return single post as a resource
        return new PostResource(true, 'Detail Data Post!', $post);
    }
}
