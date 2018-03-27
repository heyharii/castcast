<?php

namespace Castcast\Http\Controllers\API;

use Castcast\Series;
use Castcast\Lesson;
use Illuminate\Http\Request;
use Castcast\Http\Controllers\Controller;

class LessonController extends Controller
{
    public function showLesson(Series $series, Lesson $lesson){

      if ($lesson->premium && !auth()->user()->subscribed('monthly') && !auth()->user()->subscribed('yearly')) {
            return response()->json(['error' => 'Please subscribe first !']);
      }

         return response()->json(['lesson' => $lesson]);
    }

}
