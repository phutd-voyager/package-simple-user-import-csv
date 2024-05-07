<form action="{{ route('simple-user-import-csv.import') }}">
    @csrf
    <input type="file" name="file">
    <button type="submit">Submit</button>
</form>

<hr>

<a href="#">Download file temp</a>