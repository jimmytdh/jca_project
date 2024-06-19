<?php

namespace App\Http\Controllers;
use App\Models\Contestant;
use App\Models\Preliminary;
use Illuminate\Http\Request;
use DB;

class PreliminaryController extends Controller
{
    public function index()
{
    $id = session('event_id');
    $accessCode = session('access_code');

    $contestants = Contestant::where('eventID', $id)->orderBy('contestantNum', 'asc')->get();

    $mappedContestants = $contestants->map(function($con) use($accessCode) {
        $preliminaryRate = Preliminary::where('contestantID', $con->id)
        ->where('judgesCode', $accessCode)
        ->select('poise', 'projection')
        ->first();

        if ($preliminaryRate) {
            $con->poise = $preliminaryRate->poise;
            $con->projection = $preliminaryRate->projection;
            $con->total = $preliminaryRate->poise + $preliminaryRate->projection;
        } else {
            $con->poise = null;
            $con->projection = null;
            $con->total = null;
        }
        return $con;
    });

    $checkRecord =  $mappedContestants->filter(function($con){
        return $con->poise == null;
    });

    $mappedContestants = $mappedContestants->sortByDesc('total');
    $rank = 1;
    $mappedContestants->each(function ($con) use (&$rank) {
        if($con->total > 0){
            $con->rank = $rank;
            $rank++;
        }else{
            $con->rank = '?';
        }
    });

    return view('jcaJudges.pages.pre.index', [
        'contestants' => $mappedContestants->sortBy('contestantNum'),
        'isRecorded' => $checkRecord->count() < 1
    ]);
}

    public function store(Request $request){

       Preliminary::create([
            'contestantID' =>  $request->contestantID,
            'poise' => $request->poise,
            'projection' => $request->projection,
            'judgesCode' => session('access_code'),
            'eventID' => session('event_id'),
        ]);

        return response()->json("GOODS");

    }

}
