@extends('layouts.app')

@section('content')
    <h1 class="text-center">{{ $round->round_name }}</h1>
    @if (count($competitors) > 0)
        @foreach ($users as $user)
            <div class="card">
                <div class="card-body">
                    <div id="competitor{{ $user->id }}">
                        <h4>{{ $user->name }}</a></h4>
                        <small> <i>{{ $user->email }}</i></small>
                            <button class="btn btn-danger d-block mx-auto" onclick="DeleteCompetitor('{{ $user->id }}, {{ $round->id }}')">Delete</button> 
                    </div>
                </div>
            </div>
                <br>
        @endforeach
        @include('includes.addUser', ['round_id' => $round->id])
    @else
    @include('includes.addUser', ['round_id' => $round->id])
        <p>No participant found</p>
    @endif
@endsection
