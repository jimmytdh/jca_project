<?php

namespace App\Http\Controllers;
use App\Models\SemisContetant;
use Illuminate\Http\Request;

class SemisContestantCtrl extends Controller
{
    public function store(Request $request){
        
        SemisContetant::create([
            'contestantID' =>  $request->id,
            'rank' => $request->rank,
            'eventID' => $request->event,
            'category' => $request->category
        ]);

        return response()->json("GOODS");
    }
}
