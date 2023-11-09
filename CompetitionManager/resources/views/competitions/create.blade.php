@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Create Competitions</h1>
    </div>
    <div class="container">
        <form class="form" id="addCompetition">
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
            <button class="btn btn-primary d-block mx-auto" onclick="saveCompetition()">Create event</button>
        </form>
    </div>
@endsection

<script>
    function saveCompetition() {
        event.preventDefault();
        var formData = $('#addCompetition').serialize();
        $.ajax({
            type: 'POST',
            url: '/competition',
            data: formData,
            async: true,
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
