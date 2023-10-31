<?php

namespace App\Http\Controllers;

//import Model "Post"

use App\Core\App;
use App\Core\general\reports\Posts;
use App\Models\Area;
use App\Models\Company;
use App\Models\Post;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use App\Exports\PostsExport;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $filter_areas = $request->get('area') ?: [];
        $filter_companies = $request->get('company') ?: [];
        $filter_projects = $request->get('project') ?: [];
        $filter_status = $request->get('status') ?: [];
        $filter_shoot_date_start = $request->get('shoot_date_start') ?: "";
        $filter_shoot_date_end = $request->get('shoot_date_end') ?: "";
        $filter_comment = $request->get('comment') ?: "";

        // photographers
        $user = User::with(['companyUser', 'companyUser.company', 'companyUser.userAuth'])
            ->find($current_user->id);

        $builder = User::select('name', 'username', 'id as code')->with(['companyUser'])
            ->whereRelation('companyUser.company', 'is_system_owner', false);

        if ($user->companyUser->userAuth->is_system_owner == false) {
            $builder->whereRelation('companyUser', 'company_id', '=', $user->companyUser->company_id);
        }

        $photographers = $builder->orderBy('username', 'asc')->get();

        // companies
        $companies = Company::select('id as code', 'name')->where('is_system_owner', false)->orderBy('name', 'asc')->get();

        // projects
        $builder = Project::select('id as code', 'name', 'company_id')->orderBy('name', 'asc');

        if ($user->companyUser->userAuth->is_system_owner == false) {
            $builder->where('company_id', '=', $user->companyUser->company_id);
        }

        $projects = $builder->get();

        // areas
        $areas = Area::select('id as code', 'name')->get();

        // status
        $status = Status::select('id as code', 'name')->get();

        $builder = Post::read($user, $filter_photographers, $filter_companies, $filter_projects, $filter_areas, $filter_status, $filter_shoot_date_start, $filter_shoot_date_end, $filter_comment);

        $posts = [];
        if (!empty($request->all())) {
            $posts = $builder->orderBy('created_at', 'desc')->paginate(50)->withQueryString();
        }

        return response()
            ->view('app/photogps/index', [
                'photographers' => $photographers,
                'companies' => $companies,
                'projects' => $projects,
                'areas' => $areas,
                'status' => $status,
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

    public function report($id)
    {
        $builder = Post::with(['postPhoto']);
        $post = $builder->find($id);

        $temp_download_path = App::temp_download_folder();

        $now = DateTime::createFromFormat('U.u', microtime(true));

        $filename = $now->format("Ymd_Hisu") . ".xlsx";
        $dest_filepath = "{$temp_download_path}/{$filename}";

        $filepath = storage_path("app/private/reports/report_posts.xlsx");

        Posts::generate($filepath, $post, $dest_filepath);

        // Download file with custom headers
        return response()->download($dest_filepath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ])->deleteFileAfterSend(true);;
    }
}
