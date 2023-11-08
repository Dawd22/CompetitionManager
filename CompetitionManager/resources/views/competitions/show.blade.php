@extends('layouts.app')

@section('content')
    <h1 class="text-center">{{ $competition->name }}</h1>
    @if (count($rounds) > 0)
        @foreach ($rounds as $round)
            <div class="card">
                <div class="card-body">
                    <div id="round{{ $round->id }}">
                        <h4><a href='/round/{{ $round->id }}'>{{ $round->round_name }}</a></h4>
                        <h6>Kezdete: <b>{{ $round->beginning }}</b>, Vége: <b>{{ $round->end }}</b></h6>
                        <small> <i>{{ $round->location }}</i></small>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary " onclick="showRoundForm('{{ $round->id }}')">Edit</button>
                            <button class="btn btn-danger " onclick="DeleteRound('{{ $round->id }}')">Delete</button>
                        </div>
                    </div>
                </div>
                <form id="editRound{{ $round->id }}" style="display: none">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="round_name" value="{{ $round->round_name }}" class="form-control">
                        <input type="text" name="location" value="{{ $round->location }}"class="form-control">
                        <input type="date" name="beginning" value="{{ $round->beginning }}" class="form-control">
                        <input type="date" name="end" value="{{ $round->end }}" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary d-block mx-auto"
                        onclick="saveRound('{{ $round->id }}')">Save</button>
                </form>
            </div>
            <br>
        @endforeach
        @include('includes.addRound', ['competition_id' => $competition->id])
    @else
        @include('includes.addRound', ['competition_id' => $competition->id])
    @endif
@endsection


<script type="text/javascript">
    function showRoundForm(roundId) {
        var round = document.getElementById(`round${roundId}`);
        var form = document.getElementById(`editRound${roundId}`);
        if (round.style.display === "none") {
            round.style.display = "block";
            form.style.display = "none";
        } else {
            round.style.display = "none";
            form.style.display = "block";
        }
    }

    function saveRound(roundId) {
        event.preventDefault();
        var formData = $('#editRound' + roundId).serialize();
        $.ajax({
            type: 'PUT',
            url: '/round/' + roundId,
            data: formData,
            async: true,
            success: function(response) {
                showRoundForm(roundId);
                $('#editRound' + roundId + ' input[name="round_name"]').val(response.data.round_name);
                $('#editRound' + roundId + ' input[name="beginning"]').val(response.data.beginning);
                $('#editRound' + roundId + ' input[name="end"]').val(response.data.end);
                $('#editRound' + roundId + ' input[name="location"]').val(response.data.location);
                var roundDiv = $('#round' + roundId);
                roundDiv.find('h4 a').text(response.data.round_name);
                roundDiv.find('h6').html('Kezdete: <b>' + response.data.beginning + '</b>, Vége <b>' + response.data.end + '</b>');
                roundDiv.find('small i').text(response.data.location);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function DeleteRound(roundId) {
        event.preventDefault();
        $.ajax({
            type: 'DELETE',
            url: '/round/' + roundId,
            async: true,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            success: function(data) {
                var element = document.getElementById('round' + roundId);
                element.parentElement.parentElement.remove();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText, status, error);
            }
        });
    }
</script>
