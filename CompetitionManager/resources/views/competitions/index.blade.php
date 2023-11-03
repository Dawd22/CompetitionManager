@extends('layouts.app')

@section('content')
    <h1>Competitions</h1>
    @if (count($competitions) > 0)
        @foreach ($competitions as $competition)
            <div class="card">
                <h2>{{ $competition->name }}</h2>
            </div>
        @endforeach
    @else
        <p>No competitions found</p>
    @endif
@endsection
