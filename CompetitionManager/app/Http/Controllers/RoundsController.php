<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Round;
use App\Models\User;
use App\Models\Competitor;
use App\Models\Competition;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoundsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'round_name' => 'required|string',
            'beginning' => 'required',
            'end' => 'required',
            'location' => 'required|string',
            'competition_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Something went wrong']);
        }

        $beginningDate = Carbon::parse($request->input('beginning'));
        $endDate = Carbon::parse($request->input('beginning'));
        $competition = Competition::find($request->input('competition_id'));

        if($request->input('beginning') > $request->input('end') 
            || $request->input('beginning') < date( 'Y-m-d', strtotime( 'tomorrow' ) )
            ||$competition->year > $beginningDate->year || $beginningDate->year > 2040 || $endDate->year > 2040)
        {
            return response()->json(['message' => 'Wrong date']);
        }

        if(Round::where(['beginning'=> $request->input('beginning'),'competition_id'=> $request->input('competition_id')])->get()->isEmpty())
        {
            $results = $this->getRoundsBetweenDate($request);

            if($results->isEmpty()){
                
                $round = new Round;
                $round->round_name = $request->input('round_name');
                $round->beginning = $request->input('beginning');
                $round->end = $request->input('end');
                $round->location = $request->input('location');
                $round->competition_id = $request->input('competition_id');
                $round->save();

                return response()->json(['message' => 'Successful save', 'data' => $round]);
            }

            return response()->json(['message' => 'Date is between in another round']);
        }
        return response()->json(['message' => 'There is a round what has this beginning']);
    }

    /**
    * Retrieve rounds from the database that fall within a specified date range for a given competition.
    */
    public function getRoundsBetweenDate($request)
    {
        $beginning = $request->input('beginning');
        $end = $request->input('end');
        $competitionId = $request->input('competition_id');
    
        $results = DB::table('rounds')
            ->where('competition_id', $competitionId)
            ->where(function ($query) use ($beginning, $end) {
                $query->whereBetween('beginning', [$beginning, $end])
                    ->orWhere(function ($query) use ($beginning, $end) {
                        $query->where('beginning', '<', $beginning)->where('end', '>', $end);
                    })
                    ->orWhere(function ($query) use ($beginning, $end) {
                        $query->where('beginning', '>', $beginning)->where('end', '<', $end);
                    })
                    ->orWhere(function ($query) use ($beginning) {
                        $query->where('beginning', '<=', $beginning)
                            ->where('end', '>=', $beginning);
                    });
            })->get();
    
        return $results;
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $competitors = Competitor::where('round_id','=',$id)->get();
        $round = Round::Find($id);
        $users = User::join('competitors', 'users.id', '=', 'competitors.user_id')
        ->where('competitors.round_id', '=', $id)
        ->select('users.*')
        ->get();
        
        return view('rounds.competitors')->with(['competitors' => $competitors, 'round' => $round,'users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'round_name' => 'required',
            'beginning' => 'required',
            'end' => 'required',
            'location' => 'required',
            'competition_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Something went wrong']);
        }

        $round = Round::find($id);

        if (!$round) {
            return response()->json(['message' => 'Not found']);
        }
        
        $beginningDate = Carbon::parse($request->input('beginning'));
        $endDate = Carbon::parse($request->input('beginning'));
        $competition = Competition::find($request->input('competition_id'));

        if($request->input('beginning') > $request->input('end') 
            || $request->input('beginning') < date( 'Y-m-d', strtotime( 'tomorrow' ) )
            ||$competition->year > $beginningDate->year || $beginningDate->year > 2040 || $endDate->year > 2040)
        {
            return response()->json(['message' => 'Wrong date']);
        }
        
        $roundHasBeginning = Round::where(['beginning'=> $request->input('beginning'),'competition_id'=> $request->input('competition_id')])->get();

        if($roundHasBeginning->isEmpty() || $roundHasBeginning->first()->id == $round->id)
        {
            $results = $this->getRoundsBetweenDate($request);
            
            if($results->isEmpty()){
                
                $round->round_name = $request->input('round_name');
                $round->beginning = $request->input('beginning');
                $round->end = $request->input('end');
                $round->location = $request->input('location');
                $round->save();

                return response()->json(['message' => 'Successful update', 'data' => $round]);
            }
            else{
                foreach ($results as $result) {
                    if($result->id != $round->id){
                        return response()->json(['message' => 'Date is between in another round']);
                    }
                }
                $round->round_name = $request->input('round_name');
                $round->beginning = $request->input('beginning');
                $round->end = $request->input('end');
                $round->location = $request->input('location');
                $round->save();

                return response()->json(['message' => 'Successful update', 'data' => $round]);
            }

        }
        return response()->json(['message' => 'There is a round what has this beginning']);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $round = Round::find($id);
        if (!$round) {
            return response()->json(['message' => 'Not found']);
        }
        $round->delete();
        return response()->json(['message' => 'Successful deletion', 'data' => $round]);
    }
}
