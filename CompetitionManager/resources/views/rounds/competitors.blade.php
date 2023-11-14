@extends('layouts.app')

@section('content')
    <h1 class="text-center">{{ $round->round_name }}</h1>
    @if (count($competitors) > 0)
        @foreach ($users as $user)
            <div class="card">
                <div class="card-body">
                    <div id="round{{$user->id}}">
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
        @include('includes.addUser', ['round_id' => $round->id])
    @else
        @include('includes.addUser', ['round_id' => $round->id])
        <p>No participant found</p>
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
            success: function(data) {
                var element = document.getElementById('round' + userId);
                element.parentElement.parentElement.remove();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText, status, error);
            }
        });
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
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

</script>
