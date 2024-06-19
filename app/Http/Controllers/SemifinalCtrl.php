<?php

namespace App\Http\Controllers;
use App\Models\Contestant;
use App\Models\Event;
use App\Models\FinalRate;
use App\Models\Gown;
use App\Models\Judge;
use App\Models\Preliminary;
use App\Models\Semi;
use App\Models\SemisContetant;
use App\Models\Swimwear;
use Illuminate\Http\Request;

class SemifinalCtrl extends Controller
{
    public function indexJudges(Request $request){
        $id = session('event_id');
        $accessCode = session('access_code');

        $contestants = SemisContetant::where('eventID', $id)->where('category', 'semi')->get();

        $contestantsWithRate = $contestants->map(function($con) use ($accessCode) {

            $contestant = Contestant::findOrFail($con->contestantID);
            $semiScores = Semi::where('contestantID', $con->contestantID)
            ->where('judgesCode', $accessCode)
            ->select('beauty', 'poise', 'projection')
            ->first();

            if ($semiScores) {
                $contestant->beauty = $semiScores->beauty;
                $contestant->poise = $semiScores->poise;
                $contestant->projection = $semiScores->projection;
            } else {
                $contestant->beauty = 0;
                $contestant->poise = 0;
                $contestant->projection = 0;
            }

            $total = ($contestant->beauty) + ($contestant->poise) + ($contestant->projection);
            $contestant->total = $total;

            return $contestant;
        });

        $contestantsWithRate = $contestantsWithRate->sortByDesc('total');

        $rank = 1;
        $prevTotal = null;
        $contestantsWithRate->transform(function($con) use (&$rank, &$prevTotal) {
            if ($prevTotal !== null && $con->total < $prevTotal) {
                $rank++;
            }
            $con->rank = $rank;
            $prevTotal = $con->total;
            return $con;
        });

        $ranks = $contestantsWithRate->map(function($con) {
            return $con->rank;
        })->unique();
        return view('jcaJudges.pages.final.semifinal', [
            'semiContestant' =>  $contestantsWithRate->sortBy('contestantNum'),
            'ranks' =>  $ranks->count()
        ]);
    }

    public function index(Request $request) {

        $eventId = $request->event;

        $event = Event::findOrFail($eventId);
        $judges = Judge::where('eventID', $eventId)
                       ->where('category', 'Final')
                       ->get();

       $semis = SemisContetant::where('eventID', $eventId)->where('category', 'semi')->get();

       $semisContestants = $semis->map(function($con) use ($eventId, $judges) {
        $contestant = Contestant::where('id', $con->contestantID)->first();

        $totalRating = [];
        $sumOfRatings = 0;
        $rated = 0;

        foreach($judges as $judge){
            $rating = Semi::where('judgesCode', $judge->accessCode)
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

        $contestant->totalRating = $totalRating;

        if($sumOfRatings > 0){
            $contestant->total = round(($sumOfRatings / $rated), 2);
        }else{
            $contestant->total = 0;
        }

        return $contestant;
       });

       $sortedContestants = $semisContestants->sortByDesc('total');

      // Add rank to each contestant
       $rankedContestants = $sortedContestants->values()->map(function($con, $index) {
        if($con->total > 0){
            $con->rank = $index + 1;
        }else{
            $con->rank = '?';
        }
        return $con;
       });

        return view('facilitator.singleEvent.ratings.final.semi', [
            'event' => $event,
            'contestants' => $semisContestants->sortBy('contestantNum'),
            'judges' => $judges
        ]);
    }

}
