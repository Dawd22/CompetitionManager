<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;
use App\Models\Round;
use Illuminate\Support\Facades\Validator;
class CompetitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competitions = Competition::orderBy('year','desc')->paginate(4);
        return view('competitions.index')->with('competitions',$competitions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('competitions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'year' => 'required',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Something went wrong']);
        }

        if(Competition::where(['name'=> $request->input('name'), 'year'=> $request->input('year')])->get()->isEmpty()){
            $competition = new Competition;
            $competition->year = $request->input('year');

            if($competition->year >= intval(date("Y")) && $competition->year <= 2040){
            $competition->name = $request->input('name');
                $competition->description = $request->input('description');
                $competition->save();
                return response()->json(['message' => 'Successful save', 'data' => $competition]);
                }

            return response()->json(['message' => 'Wrong year']);
        }

        return response()->json(['message' => 'It is already exist']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $competition = Competition::Find($id);
        $rounds = Round::where('competition_id', $id)->get();
        return view('competitions.show')->with(['competition' => $competition, 'rounds' => $rounds]);
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
            'name' => 'required|string',
            'year' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Something went wrong']);
        }
        
        $competition = Competition::find($id);

        if (!$competition) {
            return response()->json(['message' => 'Not found']);
        }

        if($competition->name == $request->input('name') && $competition->year == $request->input('year'))
        {
            $competition->description = $request->input('description');
            $competition->save();
            return response()->json(['message' => 'Successful save', 'data' => $competition]);
        }

        else if(Competition::where(['name'=> $request->input('name'), 'year' => $request->input('year')])->get()->isEmpty()){
            if( $request->input('year')>= intval(date("Y")) &&  $request->input('year') <= 2040){
                $competition->name = $request->input('name');
                $competition->description = $request->input('description');
                $competition->year = $request->input('year');
                $competition->save();
                return response()->json(['message' => 'Successful save', 'data' => $competition]);
            }
            return response()->json(['message' => 'Wrong year']);
        }  

        return response()->json(['message' => 'It is already exist']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $competition = Competition::find($id);
        if (!$competition) {
            return response()->json(['message' => 'Not found'], 404);
        }
        
        $competition->delete();
        return response()->json(['message' => 'Successful deletion', 'data' => $competition]);
    }
}
