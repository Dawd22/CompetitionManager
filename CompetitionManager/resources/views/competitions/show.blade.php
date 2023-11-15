@extends('layouts.app')

@section('content')

    @include('includes.toast')

    <h1 class="text-center">{{ $competition->name }}</h1>
    <h4 class="text-center">{{ $competition->year }}</h4>
    <div id="roundsContainer">
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
                                <button class="btn btn-danger " onclick="deleteRound('{{ $round->id }}')">Delete</button>
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
                            <input type="hidden" name="competition_id" value="{{ $competition->id }}">
                        </div>
                        <button type="submit" class="btn btn-primary d-block mx-auto"
                            onclick="saveRound('{{ $round->id }}')">Save</button>
                    </form>
                </div>
                <br>
            @endforeach
    </div>
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

    function showToast(message) {
        var toastElement = document.querySelector('.toast');
        var toast = new bootstrap.Toast(toastElement);
        document.getElementById('toastMessage').innerText = message;
        toast.show();
        setTimeout(function() {
            toast.hide();
        }, 4500);
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
                showToast(response.message);
                if (response.message == "Successful update") {
                    $('#editRound' + roundId + ' input[name="round_name"]').val(response.data.round_name);
                    $('#editRound' + roundId + ' input[name="beginning"]').val(response.data.beginning);
                    $('#editRound' + roundId + ' input[name="end"]').val(response.data.end);
                    $('#editRound' + roundId + ' input[name="location"]').val(response.data.location);
                    var roundDiv = $('#round' + roundId);
                    roundDiv.find('h4 a').text(response.data.round_name);
                    roundDiv.find('h6').html('Kezdete: <b>' + response.data.beginning + '</b>, Vége <b>' +
                        response.data.end + '</b>');
                    roundDiv.find('small i').text(response.data.location);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function deleteRound(roundId) {
        event.preventDefault();
        $.ajax({
            type: 'DELETE',
            url: '/round/' + roundId,
            async: true,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            success: function(response) {
                showToast(response.message);
                if (response.message == "Successful deletion") {
                    var element = document.getElementById('round' + roundId);
                    element.parentElement.parentElement.remove();
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function addRound() {
        event.preventDefault();
        var formData = $('#addRound').serialize();
        $.ajax({
            type: 'POST',
            url: '/round',
            data: formData,
            async: true,
            success: function(response) {
                showToast(response.message);
                if (response.message == "Successful save") {
                    var newRound = response.round;
                    var newCardHtml =
                    `<div class="card">
                        <div class="card-body">
                            <div id="round${newRound.id}">
                                <h4><a href='/round/${newRound.id}'>${newRound.round_name}</a></h4>
                                <h6>Kezdete: <b>${newRound.beginning}</b>, Vége: <b>${newRound.end}</b></h6>
                                <small> <i>${newRound.location}</i></small>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary " onclick="showRoundForm('${newRound.id}')">Edit</button>
                                    <button class="btn btn-danger " onclick="deleteRound('${newRound.id}')">Delete</button>
                                </div>
                            </div>
                        </div>
                        <form id="editRound${newRound.id}" style="display: none">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="round_name" value="${newRound.round_name}" class="form-control">
                                <input type="text" name="location" value="${newRound.location}"class="form-control">
                                <input type="date" name="beginning" value="${newRound.beginning}" class="form-control">
                                <input type="date" name="end" value="${newRound.end}" class="form-control">
                                <input type="hidden" name="competition_id" value="${newRound.competition_id}">
                            </div>
                            <button type="submit" class="btn btn-primary d-block mx-auto"
                                onclick="saveRound('${newRound.id}')">Save</button>
                        </form>
                    </div>
                    <br>`;

                    $("#roundsContainer").append(newCardHtml);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
