<form action="{{ route('simple-user-import-csv.import') }}">
    @csrf
    <input type="file" name="file">
    <button type="submit">Submit</button>
</form>

<hr>

<a href="{{ route('simple-user-import-csv.downloadFileTemp') }}">Download file temp</a>