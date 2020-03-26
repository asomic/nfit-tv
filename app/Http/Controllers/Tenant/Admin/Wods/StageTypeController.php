<?php

namespace App\Http\Controllers\Tenant\Admin\Wods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Wods\StageType;

class StageTypeController extends Controller
{
    /**
     *  Get all the stages types of an specific clase type
     *
     *  @return  json
     */
    public function show($stage_type)
    {
        $stages = StageType::where('clase_type_id', $stage_type)
                           ->get(['id', 'stage_type', 'clase_type_id', 'featured']);

        return response()->json(['data' => $stages]);
    }

    /**
     *  Delete Stage Type
     *
     *  @return  json
     */
    public function destroy(StageType $stage_type)
    {
        $stage_type->delete();

        return response()->json(['success' => 'Etapa eliminada correctamente'], 200);
    }
}
