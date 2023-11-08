<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Round;
use App\Models\User;
use App\Models\Competitor;
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
            return redirect()->back()->withErrors($validator);
        }

        $round = new Round;
        $round->round_name = $request->input('title');
        $round->beginning = $request->input('beginning');
        $round->end = $request->input('end');
        $round->location = $request->input('location');
        $round->competition_id = $request->input('competition_id');
        $round->save();

        return redirect()->back();
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
        $round = Round::find($id);

        if (!$round) {
            return response()->json(['message' => 'Not found'], 404);
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
            return response()->json(['message' => 'Not found'], 404);
        }
        $round->delete();
        return response()->json(['message' => 'Successful deletion', 'data' => $round]);
    }
}
