<?php

namespace App\Http\Controllers\Tenant\Admin\Videos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    /**
     *  Go to Index Video view to Upload
     *
     *  @return  view
     */
    public function index()
    {
        return view('admin.videos.index');
    }

    /**
     *  Upload Video to Vimeo
     *
     *  @return type
     */
    public function upload()
    {
        // code
    }
}
