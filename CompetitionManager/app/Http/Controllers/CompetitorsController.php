<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Competitor;
use App\Models\Round;
use Illuminate\Support\Facades\DB;

class CompetitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'name' => 'required|string',
            'email' => 'required',
            'round_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = User::where('email', '=', $request->email)->get();

        if($user->isEmpty()){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            $competitor = new Competitor;
            $competitor->round_id = $request->round_id;
            $competitor->user_id = $user->id;   
            $competitor->save();
            return redirect()->back();
        }
        else{
            if(Competitor::where(['user_id'=>  $user->first()->id, 'round_id' => $request->round_id])->get()->isEmpty()){
                $competitor = new Competitor;
                $competitor->round_id = $request->round_id;
                $competitor->user_id = $user->id;;
                $competitor->save();
                return redirect()->back();
            }
            else{
                return redirect()->back()->withErrors('He is a participant');
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }

    public function __invoke(Request $request)
    {
        $user_id = $request->input('user_id');
        $round_id = $request->input('round_id');
    
        try {
            DB::table('competitors')
                ->where('user_id', $user_id)
                ->where('round_id', $round_id)
                ->delete();
            
            return response()->json(['message' => 'Successful deletion']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error during deletion'], 404);
        }
    }
}
