@extends('tenant.layouts.app')

@section('tenantContent')
<div class="page-content">
    <div class="flexbox-b mb-5">
        <span class="mr-4 static-badge badge-pink">
            <i class="fa fa-video-camera"></i>
        </span>

        <div>
            <h5 class="font-strong">Subir Videos</h5>
        </div>
    </div>

    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" class="form-control" placeholder="Dale un nombre al video"/>
        
        <br>
        
        <input type="file"
               name="video" 
               class="form-control"
               accept="video/mp4,video/3gp,video/flv"/>
        
        <button class="btn btn-success">
            <i class="fa fa-upload"></i>
            Subir video
        </button>
    </form>
</div>
@endsection

@section('tenantCss') {{-- stylesheet para esta vista --}}

@endsection


@section('tenantScripts') {{-- scripts para esta vista --}}

@endsection
