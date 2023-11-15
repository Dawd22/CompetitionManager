@extends('layouts.app')

@section('content')

@include('includes.toast')

    <h1 class="text-center">{{ $round->round_name }}</h1>
    <div id="competitorContainer">
        @if (count($competitors) > 0)
            @foreach ($users as $user)
                <div class="card">
                    <div class="card-body">
                        <div id="round{{ $user->id }}">
                            <div id="competitor{{ $user->id }}">
                                <h4>{{ $user->name }}</a></h4>
                                <small> <i>{{ $user->email }}</i></small>
                                <button class="btn btn-danger d-block mx-auto"
                                    onclick="DeleteCompetitor('{{ $user->id }}', '{{ $round->id }}')">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endforeach
    </div>
    @include('includes.addUser', ['round_id' => $round->id])
@else
    @include('includes.addUser', ['round_id' => $round->id])
    <p id="noParticipant">No participant found</p>
    @endif
@endsection

<script>
    function DeleteCompetitor(userId, roundId) {
        event.preventDefault();
        $.ajax({
            type: 'DELETE',
            data: {
                user_id: userId,
                round_id: roundId
            },
            url: '/competitor',
            async: true,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            success: function(response) {
                alert(response.message);
                if (response.message == "Successful deletion") {
                    var element = document.getElementById('round' + userId);
                    element.parentElement.parentElement.remove();
                }
                DeleteCompetitor
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText, status, error);
            }
        });
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

    function addCompetitor() {
        event.preventDefault();
        var formData = $('#addCompetitor').serialize();
        $.ajax({
            type: 'POST',
            url: '/competitor',
            data: formData,
            async: true,
            success: function(response) {
                alert(response.message);
                if (response.message == "Successful save") {

                    var newUser = response.user;
                    var newCompetitor = response.competitor;
                    var newCardHtml =
                        `<div class="card">
                                <div class="card-body">
                                    <div id="round${newUser.id}">
                                        <div id="competitor${newUser.id}">
                                            <h4>${newUser.name}</h4>
                                            <small> <i>${newUser.email}</i></small>
                                            <button class="btn btn-danger d-block mx-auto"
                                                onclick="DeleteCompetitor('${newUser.id}', '${newCompetitor.round_id}')">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <br>`;
                    $('#noParticipant').remove();
                    $("#competitorContainer").append(newCardHtml);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
