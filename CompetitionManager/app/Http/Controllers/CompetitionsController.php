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
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $competition = new Competition;
        $competition->name = $request->input('name');
        $competition->year = $request->input('year');
        $competition->description = $request->input('description');
        $competition->save();

        // ...

        return redirect()->route('competition.index')->with('success', 'Format sent successfully!');
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
        $competition = Competition::find($id);

        if (!$competition) {
            return response()->json(['message' => 'Not found'], 404);
        }
        
        $competition->name = $request->input('name');
        $competition->description = $request->input('description');
        $competition->year = $request->input('year');
        $competition->save();
        return response()->json(['message' => 'Successful save', 'data' => $competition]);
    
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
