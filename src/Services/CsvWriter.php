<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

use Illuminate\Support\Facades\Response;

class CsvWriter
{
    protected $headers;

    public function __construct()
    {
        $this->headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"'
        ];
    }

    public function download(array $data = [])
    {
        $headers = config('simple_user_import_csv.csv_reader.header_format', ['name', 'email', 'password']);

        $file = fopen('php://temp', 'w+');
        fputcsv($file, $headers);

        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        rewind($file);
        $csv = stream_get_contents($file);
        fclose($file);

        return Response::streamDownload(function () use ($csv) {
            echo $csv;
        }, 'users.csv', $this->headers);
    }
}
