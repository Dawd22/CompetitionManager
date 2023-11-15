@extends('layouts.app')

@section('content')

    @include('includes.toast')

    <div class="text-center">
        <h1>Competitions</h1>
    </div>
    @if (count($competitions) > 0)
        @foreach ($competitions as $competition)
            <div class="card" id="competition-list">
                <div class="card-body">
                    <div id="competition{{ $competition->id }}">
                        <h4><a href='/competition/{{ $competition->id }}'>{{ $competition->name }}</a></h4>
                        <h6>{{ $competition->year }}</h6>
                        <small> <i> {{ $competition->description }}</i></small>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary " onclick="showForm('{{ $competition->id }}')">Edit</button>
                            <button class="btn btn-danger "
                                onclick="deleteCompetition('{{ $competition->id }}')">Delete</button>
                        </div>
                    </div>
                    <form id="editCompetition{{ $competition->id }}" style="display: none">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" value="{{ $competition->name }}" class="form-control">
                            <input type="text" name="description" value="{{ $competition->description }}"
                                class="form-control">
                            <input type="number" name="year" value="{{ $competition->year }}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary d-block mx-auto"
                            onclick="saveCompetition('{{ $competition->id }}')">Save</button>
                        <button type="submit" class="btn btn-warning d-block mx-auto"
                            onclick="showForm('{{ $competition->id }}')">Cancel</button>
                    </form>

                </div>
            </div>
            <br>
        @endforeach
        {{ $competitions->links('pagination::bootstrap-4') }}
    @else
        <p>No competitions found</p>
    @endif
@endsection

<script type="text/javascript">
    function showForm(competitionId) {
        event.preventDefault();
        var competition = document.getElementById(`competition${competitionId}`);
        var form = document.getElementById(`editCompetition${competitionId}`);
        if (competition.style.display === "none") {
            competition.style.display = "block";
            form.style.display = "none";
        } else {
            competition.style.display = "none";
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

    function saveCompetition(competitionId) {
        event.preventDefault();
        var formData = $('#editCompetition' + competitionId).serialize();
        $.ajax({
            type: 'PUT',
            url: '/competition/' + competitionId,
            data: formData,
            async: true,
            success: function(response) {
                showForm(competitionId);
                showToast(response.message);
                if (response.message == "Successful save") {
                    $('#editCompetition' + competitionId + ' input[name="name"]').val(response.data.name);
                    $('#editCompetition' + competitionId + ' input[name="description"]').val(response.data
                        .description);
                    $('#editCompetition' + competitionId + ' input[name="year"]').val(response.data.year);
                    var competitionDiv = $('#competition' + competitionId);
                    competitionDiv.find('h4 a').text(response.data.name);
                    competitionDiv.find('h6').text(response.data.year);
                    competitionDiv.find('small i').text(response.data.description);
                }

            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function deleteCompetition(competitionId) {
        event.preventDefault();
        $.ajax({
            type: 'DELETE',
            url: '/competition/' + competitionId,
            async: true,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            success: function(response) {
                showToast(response.message);
                if (response.message == "Successful deletion") {
                    var element = document.getElementById('competition' + competitionId);
                    element.parentElement.parentElement.remove();
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
