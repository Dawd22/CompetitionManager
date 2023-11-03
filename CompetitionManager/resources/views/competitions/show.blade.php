@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Rounds</h1>
    </div>
    @if (count($rounds) > 0)
        @foreach ($rounds as $round)
            <div class="card">
                <div class="card-body">
                    <h4><a href='/competition/{{$round->id}}'>{{ $round->round_name }}</a></h4>
                    <h6>Kezdete: {{ $round->beginning }}, Vége: {{ $round->end }}</h6>
                    <small>{{$round->location}}</small>
                </div>
            </div>
        @endforeach
    @else
        <p>No rounds found</p>
    @endif
@endsection
