<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;
use App\Models\Round;
class CompetitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competitions = Competition::all();
        return view('competitions.index')->with('competitions',$competitions);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
