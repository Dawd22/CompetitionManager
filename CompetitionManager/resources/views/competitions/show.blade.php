@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>{{ $competition->name }}</h1>
    </div>
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
        <div class="container">
            <form action="{{ route('competition.store') }}" method="post" class="form">
                @csrf
                <div class="form-group">
                    <label for="name">Name of the event</label>
                    <input type="text" name="name" placeholder="Name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="year">Year of event</label>
                    <input type="number" name="year" placeholder="YYYY" min="2023" max="2040" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" placeholder="Description" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary d-block mx-auto">Create event</button>
            </form>
        </div>
    @else
        <p>No rounds found</p>
        <div class="container">
            <form action="{{ route('competition.store') }}" method="post" class="form">
                @csrf
                <div class="form-group">
                    <label for="title">Title of the round</label>
                    <input type="text" name="title" placeholder="Title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="year">Year of event</label>
                    <input type="number" name="year" placeholder="YYYY" min="2023" max="2040" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" placeholder="Description" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary d-block mx-auto">Create event</button>
            </form>
        </div>
    @endif
@endsection
