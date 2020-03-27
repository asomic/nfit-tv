<?php

namespace App\Http\Controllers\Tenant\Admin\Videos;

use Vimeo;
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
        return view('tenant.admin.videos.index');
    }

    /**
     *  Upload Video to Vimeo
     *
     *  @return type
     */
    public function store(Request $request)
    {
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $fileName = strtolower(time() . '-' . $file->getClientOriginalName());
            $file->move('videos/', $fileName);
            $video = Vimeo::upload(
                'videos/' . $fileName,
                ['title' => $request->title]
            );

            if ($video) {
                unlink(public_path('videos/' . $fileName));
            }
            return back()->with('success', 'Video Subido correctamente');
        }

        return back()->with('warning', 'Debe elegir un archivo para subir');
    }
}
