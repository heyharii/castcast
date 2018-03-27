<?php

namespace Castcast\Http\Controllers;

use Castcast\Series;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function welcome(){
        return view('welcome')->withSeries(Series::all());
    }

    public function series(Series $series){
        return view('series')->withSeries($series);
    }

    public function showAllSeries() {
        return view('all-series')->withSeries(Series::all());
    }
}
