@extends('tenant.layouts.app')

@section('tenantContent')
<div class="page-content fade-in-up">
    <div class="flexbox-b mb-5">
        <span class="mr-4 static-badge badge-pink"><i class="fa fa-pencil"></i></span>
        <div>
            <h5 class="font-strong">Videos de CrossFit</h5>
            <div class="text-light">2 encontrados</div>
        </div>
    </div>
    <div class="input-group-icon input-group-icon-left input-group-lg mb-5">
        <span class="input-icon input-icon-right"><i class="fa-search"></i></span>

        <input class="form-control form-control-air border-0 font-light font-poppins" 
                type="text"
                placeholder="Buscar ..." style="box-shadow:0 3px 6px rgba(10,16,20,.15);">
    </div>
   
    @forelse ($videos as $video)
    {{-- {{ dd($video) }} --}}
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="rel">
                        {!! $video['embed']['html'] !!}
                    </div>
                    <div class="card-body">
                        <h4 class="card-title mb-2">
                            <a class="text-primary">Clase de Miercoles</a>
                        </h4>
                        <div class="text-muted mb-3">26 de Marzo 2020</div>
                </div>
            </div>
        </div>
    </div>
    @empty
        No hay videos que mostrar
    @endforelse

</div>
@endsection

@section('tenantCss') {{-- stylesheet para esta vista --}}

@endsection



@section('tenantScripts') {{-- scripts para esta vista --}}

@endsection
