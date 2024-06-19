<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Event;
use App\Models\FinalRate;
use App\Models\Judge;
use App\Models\Semi;
use App\Models\SemisContetant;
use Illuminate\Http\Request;

class FinalCtrl extends Controller
{
    public function indexJudges() {
        $eventId = session('event_id');
        $access_code = session('access_code');
        $event = Event::findOrFail($eventId);

       $semis = SemisContetant::where('eventID', $eventId)->where('category', 'final')->get();

       $contestants = $semis->map(function($con) use ($access_code) {
        $contestant = Contestant::findOrFail($con->contestantID);

        $rating = FinalRate::where('judgesCode', $access_code)->where('contestantID', $con->contestantID)->select('beauty', 'poise', 'projection')->first();

        if($rating){
            $contestant->beauty = $rating->beauty;
            $contestant->poise= $rating->poise;
            $contestant->projection = $rating->projection;
            $contestant->total = $rating->beauty + $rating->projection + $rating->poise;
        }else{
            $contestant->beauty = 0;
            $contestant->poise= 0;
            $contestant->projection = 0;
            $contestant->total = 0;
        }

        return $contestant;
       });

       $contestants = $contestants->sortByDesc('total');

       $rank = 1;
       $prevTotal = null;
       $contestants->transform(function($con) use (&$rank, &$prevTotal) {
           if ($prevTotal !== null && $con->total < $prevTotal) {
               $rank++;
           }
           $con->rank = $rank;
           $prevTotal = $con->total;
           return $con;
       });

       $ranks = $contestants->map(function($con) {
           return $con->rank;
       })->unique();


        return view('jcaJudges.pages.final.final', [
            'contestants' => $contestants->sortBy('contestantNum'),
            'ranks' =>  $ranks->count()
        ]);
    }

    public function indexAdmin(Request $request){
        $eventId = $request->event;

        $event = Event::findOrFail($eventId);
        $judges = Judge::where('eventID', $eventId)
                       ->where('category', 'Final')
                       ->get();

        $final = SemisContetant::where('eventID', $eventId)->where('category', 'final')->get();


        $contestants = $final->map(function($con) use ($judges) {
            $contestantDetails = Contestant::findOrFail($con->contestantID);

        $totalRating = [];
        $sumOfRatings = 0;
        $rated = 0;

        foreach($judges as $judge){
            $rating = FinalRate::where('judgesCode', $judge->accessCode)
            ->where('contestantID', $con->contestantID)
            ->select('beauty', 'poise', 'projection')
            ->first();

           if($rating){
            $individualRating = $rating->beauty + $rating->poise + $rating->projection;
            $totalRating[] = $individualRating;
            $sumOfRatings += $individualRating;
            $rated ++;
           }else{
            $totalRating[] = 0;
           }
        }

        $contestantDetails->totalRate = $totalRating;


        if($sumOfRatings > 0){
            $contestantDetails->total = round(($sumOfRatings / $rated), 2);
        }else{
            $contestantDetails->total = 0;
        }

        return $contestantDetails;
        });

        $sortedContestants = $contestants->sortByDesc('total');

        // Add rank to each contestant
         $rankedContestants = $sortedContestants->values()->map(function($con, $index) {
         if($con->total > 0){
            $con->rank = $index + 1;
         }else{
            $con->rank = '?';
         }
          return $con;
         });



        return view('facilitator.singleEvent.ratings.final.final', [
            'event' => $event,
            'contestants' => $contestants->sortBy('contestantNum'),
            'judgesFin' => $judges
        ]);
    }

    public function store(Request $request){

        FinalRate::create([
            'contestantID' =>  $request->contestantID,
            'judgesCode' => session('access_code'),
            'eventID' => session('event_id'),
            'beauty' =>  $request->beauty,
            'poise' =>  $request->poise,
            'projection' =>  $request->projection,
        ]);

        return response()->json("GOODS");
    }

}
