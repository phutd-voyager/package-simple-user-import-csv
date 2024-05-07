<form action="{{ route('simple-user-import-csv.upload') }}">
    @csrf
    <input type="file" name="file">
    <button type="submit">Submit</button>
</form>

<hr>

<a href="#">Download file temp</a>