@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    
    <hr>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>

    <hr>
@endif

<form action="{{ route('simple-user-import-csv.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required accept=".csv">
    <button type="submit">Submit</button>
</form>

<hr>

<a href="{{ route('simple-user-import-csv.downloadFileTemp') }}" target="_blank">Download file temp</a>