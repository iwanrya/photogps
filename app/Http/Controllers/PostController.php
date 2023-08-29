<?php

namespace App\Http\Controllers;

//import Model "Post"

use App\Core\App;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(Request $request)
    {
        $current_user = Auth::user();

        // get filters
        $filter_photographers = $request->get('photographer') ?: [];
        $areas = $request->get('area') ?: [];
        $companies = $request->get('company') ?: [];
        $projects = $request->get('project') ?: [];
        $status = $request->get('status') ?: [];
        $shoot_date_start = $request->get('shoot_date_start') ?: "";
        $shoot_date_end = $request->get('shoot_date_end') ?: "";
        $comment = $request->get('comment') ?: "";

        $user = User::with(['companyUser', 'companyUser.company', 'companyUser.userAuth'])
            ->find($current_user->id);

        $builder = User::select('name', 'username', 'id as code')->with(['companyUser']);

        if ($user->companyUser->userAuth->is_system_owner == false) {
            $builder->whereRelation('companyUser', 'company_id', '=', $user->companyUser->company_id);
        }

        $photographers = $builder->orderBy('username', 'asc')->get();

        $builder = Post::read($user, $filter_photographers, $companies, $projects, $areas, $status, $shoot_date_start, $shoot_date_end, $comment);

        $posts = $builder->orderBy('created_at', 'desc')->paginate(50)->withQueryString();
        
        return response()
            ->view('app/photogps/index', [
                'photographers' => $photographers,
                'posts' => $posts
            ], 200);
    }

    public function original_image(string $id)
    {
        $post = Post::find($id);

        if ($post) {
            $this->showImage(App::photo_mobile_original_file_location() . $post->getRawOriginal('image'));
        } else {
            return response('', 404);
        }
    }

    private function showImage($file)
    {
        $imginfo = getimagesize($file);
        header("Content-type: {$imginfo['mime']}");
        readfile($file);
    }

    public function original_images(string $id)
    {
        $builder = Post::with(['postPhoto']);
        $post = $builder->find($id);

        if ($post) {
            $photos = [];
            foreach ($post->postPhoto as $photo) {
                $photos[] = App::photo_mobile_original_file_location() . $photo->getRawOriginal('image');
            }
            $this->zip_images($photos);
        } else {
            return response('', 404);
        }
    }

    public function images(string $id)
    {
        $builder = Post::with(['postPhoto']);
        $post = $builder->find($id);

        if ($post) {
            $photos = [];
            foreach ($post->postPhoto as $photo) {
                $photos[] = App::photo_mobile_noexif_file_location() . $photo->getRawOriginal('image');
            }
            $this->zip_images($photos);
        } else {
            return response('', 404);
        }
    }

    private function zip_images($photos)
    {
        $zip = new \ZipArchive();
        $fileName = Date('Ymdhisu') . ".zip";

        $temp_download_path = App::temp_download_folder();
        File::makeDirectory($temp_download_path, $mode = 0777, true, true);

        if ($zip->open($temp_download_path . $fileName, \ZipArchive::CREATE) == TRUE) {
            foreach ($photos as $key => $photo) {
                $relativeName = basename($photo);
                $zip->addFile($photo, $relativeName);
            }
            $zip->close();
        }

        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile($temp_download_path . $fileName);
        exit;
        // return response()->download($temp_download_path . $fileName, $fileName);
    }
}
