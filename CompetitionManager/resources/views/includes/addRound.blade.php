<div class="container">
    <h2 class="text-center">Add round for the event</h2>
    <form action="{{ route('round.store') }}" method="post" class="form" id="addRound">
        @csrf
        <div class="form-group">
            <label for="title">Title of the round</label>
            <input type="text" name="title" placeholder="Title" class="form-control">
        </div>
        <div class="form-group">
            <label for="beginning">Beginning of round</label>
            <input type="date" name="beginning" class="form-control">
        </div>
        <div class="form-group">
            <label for="end">End of round</label>
            <input type="date" name="end" class="form-control">
        </div>
        <div class="form-group">
            <label for="Location">Location of the round</label>
            <input type="text" name="location" placeholder="Location" class="form-control">
        </div>
        <input type="hidden" name="competition_id" value="{{ $competition_id }}">
        <button class="btn btn-primary d-block mx-auto" onclick="addRound()">Create round</button>
    </form>
</div>