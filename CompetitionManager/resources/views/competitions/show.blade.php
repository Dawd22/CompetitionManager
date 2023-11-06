@extends('layouts.app')

@section('content')
    <h1 class="text-center">{{ $competition->name }}</h1>
    @if (count($rounds) > 0)
        @foreach ($rounds as $round)
            <div class="card">
                <div class="card-body">
                    <h4><a href='/competition/{{ $round->id }}'>{{ $round->round_name }}</a></h4>
                    <h6>Kezdete: <b>{{ $round->beginning }}</b>, Vége: <b>{{ $round->end }}</b></h6>
                    <small> <i>{{ $round->location }}</i></small>
                </div>
            </div>
            <br>
        @endforeach
        @include('includes.addRound',['competition_id' => $competition->id])
    @else
        @include('includes.addRound', ['competition_id' => $competition->id])
    @endif
@endsection
