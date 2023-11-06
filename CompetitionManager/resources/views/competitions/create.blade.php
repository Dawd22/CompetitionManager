@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Create Competitions</h1>
    </div>
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
@endsection
