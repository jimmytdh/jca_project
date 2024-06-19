<?php
namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Judge;
use App\Models\Event;
use App\Models\Preliminary;
use Illuminate\Http\Request;

class PreliminaryAdminCtrl extends Controller
{
    public function index(Request $request)
{
    $eventId = $request->event;

    $event = Event::find($eventId);

    $contestants = Contestant::where('eventID', $eventId)->get();
    $judges = Judge::where('eventID', $eventId)->where('category', 'Preliminary')->get();

    $mappedContestants = $contestants->map(function($con) use ($judges) {
        $total = [];
        $totalRate = 0;

        foreach($judges as $judge){
            $contestantRates = Preliminary::where('contestantID', $con->id)
            ->where('judgesCode', $judge->accessCode)
            ->select('poise', 'projection')
            ->first();

            if($contestantRates){
                $individualTotal = $contestantRates->projection + $contestantRates->poise;
                $total[] = $individualTotal;
                $totalRate += $individualTotal;
            }else{
                $total[] = 0;
            }
        }

        $con->total = $total;
        $con->totalRate = round(($totalRate / $judges->count()), 2);

        return $con;
    });

    $mappedContestants = $mappedContestants->sortByDesc('totalRate');
    $rank = 1;
    $mappedContestants->each(function ($con) use (&$rank) {
        if($con->totalRate > 0){
            $con->rank = $rank;
            $rank++;
        }else{
            $con->rank = '?';
        }
    });

    return view("facilitator.singleEvent.ratings.preliminary.index", [
        'event' => $event,
       'contestants' => $mappedContestants->sortBy('contestantNum'),
        'judges' => $judges
    ]);
}

}
