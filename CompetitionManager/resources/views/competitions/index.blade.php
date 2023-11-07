@extends('layouts.app')

</script>
@section('content')
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
                        <button class="btn btn-primary d-block mx-auto"
                            onclick="showForm('{{ $competition->id }}')">Edit</button>
                    </div>
                    <form id="editCompetition{{$competition->id}}" style="display: none">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" value="{{ $competition->name }}" class="form-control">
                            <input type="text" name="description" value="{{ $competition->description }}"
                                class="form-control">
                            <input type="number" name="description" value="{{ $competition->year }}"
                                class="form-control">
                            <button type="submit" class="btn btn-primary d-block mx-auto">Mentés</button>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <script>
            </script>
        @endforeach
        
    @else
        <p>No competitions found</p>
    @endif
@endsection
<script type="text/javascript">
    function showForm(competitionId) {
        var competition = document.getElementById(`competition${competitionId}`);
        var form = document.getElementById(`editCompetition${competitionId}`);
        console.log(form);
        if (competition.style.display === "none") {
            competition.style.display = "block";
            form.style.display = "none";
        } else {
            competition.style.display = "none";
            form.style.display = "block";
        }
    }
</script>

