<?php

namespace App\Http\Controllers\Tenant;

use Vimeo;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     *  Create a new controller instance.
     *
     *  @return  void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     *  Show the application dashboard.
     *
     *  @return  \Illuminate\View\View
     */
    public function index()
    {
        // if (!Session::has('clases-type-id')) {
        //     Session::put('clases-type-id', 1);
        //     Session::put('clases-type-name', ClaseType::find(1)->clase_type);
        // }

        $response = Vimeo::request('/me/videos', ['per_page' => 10], 'GET');
        
        if ($response['status'] === 200) {
            $videos = $response['body']['data'];
        }

        $videos = $videos ?? [];

        // dd($videos);
        
        return view('tenant.home', compact('videos'));
    }

    public function cn()
    {
        // dd(app(\Hyn\Tenancy\Environment::class)->tenant());
        // return md5(mt_rand(1, 50));
        // $cn = app(Connection::class)->get();
        // $uuid = $cn->getConfig()['uuid'];
        // $website = Website::where('uuid', $uuid)->first();
        // $hostname = Hostname::find($website->id);
        // $fqdn = $hostname->fqdn;
        // $hostnameParts = explode(".", $fqdn);
        // return $hostnameParts;
        // return $hostnameParts[0];
    }

}
