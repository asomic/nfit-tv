<?php

namespace App\Http\Controllers\Tenant\Admin\Videos;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExcel;
use App\Models\Tenant\Bills\Bill;
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
