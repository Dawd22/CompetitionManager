@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Competitions</h1>
    </div>
    @if (count($competitions) > 0)
        @foreach ($competitions as $competition)
            <div class="card">
                <div class="card-body">
                    <h4><a href='/competition/{{$competition->id}}'>{{ $competition->name }}</a></h4>
                    <h6>{{ $competition->year }}</h6>
                </div>
            </div>
        @endforeach
    @else
        <p>No competitions found</p>
    @endif
@endsection
