<?php

namespace Castcast\Http\Controllers\API;

use Castcast\Series;
use Illuminate\Http\Request;
use Castcast\Http\Controllers\Controller;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function series($id){
        $series = Series::findOrFail($id);
        return response()->json(['series' => $series], 200);
    }

    public function showAllSeries() {
        $series = Series::all();
        return response()->json(['series' => $series], 200);
    }

   
}