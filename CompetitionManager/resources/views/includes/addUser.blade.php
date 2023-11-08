<div class="container">
    <h2 class="text-center">Add participant</h2>
    <form action="{{ route('competitor.store') }}" method="post" class="form">
        @csrf
        <div class="form-group">
            <label for="name">Competitor's name</label>
            <input type="text" name="name" placeholder="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Competitor's email</label>
            <input type="text" name="email" placeholder="example@email.com" class="form-control">
        </div>
        <input type="hidden" name="round_id" value="{{ $round_id }}">
        <button type="submit" class="btn btn-primary d-block mx-auto">Add participant</button>
    </form>
</div>