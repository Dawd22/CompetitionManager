<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Round;
use App\Models\User;
use App\Models\Competitor;
use Illuminate\Support\Facades\DB;
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
            'title' => 'required|string',
            'beginning' => 'required',
            'end' => 'required',
            'location' => 'required',
            'competition_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Something went wrong']);
        }

        if($request->input('beginning') > $request->input('end')|| $request->input('beginning') < date( 'Y-m-d', strtotime( 'tomorrow' ) )){
            return response()->json(['message' => 'Wrong date']);
        }
        if(Round::where(['beginning'=> $request->input('beginning'),'competition_id'=> $request->input('competition_id')])->get()->isEmpty())
        {
            $beginning = $request->input('beginning');
            $end = $request->input('end');
            $competitionId = $request->input('competition_id');
            $results = DB::table('rounds')->where('competition_id', $competitionId)->where(function ($query) use ($beginning, $end) {
                $query->whereBetween('beginning', [$beginning, $end])->orWhere(function ($query) use ($beginning, $end) {
                        $query->where('beginning', '<', $beginning)->where('end', '>', $end);
                    })->orWhere(function ($query) use ($beginning, $end) {
                        $query->where('beginning', '>', $beginning)->where('end', '<', $end);
                    })->orWhere(function ($query) use ($beginning) {
                        $query->where('beginning', '<=', $beginning)
                            ->where('end', '>=', $beginning);
                    });})->get();

            if($results->isEmpty()){
                $round = new Round;
                $round->round_name = $request->input('title');
                $round->beginning = $request->input('beginning');
                $round->end = $request->input('end');
                $round->location = $request->input('location');
                $round->competition_id = $request->input('competition_id');
                $round->save();
                return response()->json(['message' => 'Successful save', 'data' => $round]);
            }
            return response()->json(['message' => 'Date is between in another date']);
        }
        return response()->json(['message' => 'There is a date what has this beginning']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $competitors = Competitor::where('round_id','=',$id)->get();
        $round = Round::Find($id);
        $users = [];
        foreach ($competitors as $competitor) {
            $user = User::find($competitor->user_id);
            if($user != null){
            array_push($users, $user);}
        }
        
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
            
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Something went wrong']);
        }

        $round = Round::find($id);

        if (!$round) {
            return response()->json(['message' => 'Not found']);
        }
        
        $round->round_name = $request->input('round_name');
        $round->beginning = $request->input('beginning');
        $round->end = $request->input('end');
        $round->location = $request->input('location');
        $round->save();
        return response()->json(['message' => 'Successful save', 'data' => $round]);
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
