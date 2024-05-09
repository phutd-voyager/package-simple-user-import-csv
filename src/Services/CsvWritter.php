<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

use Illuminate\Support\Facades\Response;

class CsvWritter implements Interfaces\CsvWritterInterface
{
    protected $headers;

    public function __construct()
    {
        $this->headers = [
            'Content-Type' => 'text/csv',
        ];
    }

    public function download(array $data = [])
    {
        $headers = $this->getHeaderFormat();

        $file = fopen('php://temp', 'w+');
        fputcsv($file, $headers);

        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        rewind($file);
        $csv = stream_get_contents($file);
        fclose($file);


        $fileName = $this->getFileName();

        $this->addHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return Response::streamDownload(function () use ($csv) {
            echo $csv;
        }, 'users.csv', $this->getHeaders());
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }

    protected function getHeaderFormat(): array
    {
        return config('simple_user_import_csv.csv_reader.header_format', ['name', 'email', 'password']);
    }

    public function getFileName(): string
    {
        return config('simple_user_import_csv.csv_reader.file_name', 'users.csv');
    }

    public function setFileName(string $fileName)
    {
        config(['simple_user_import_csv.csv_reader.file_name' => $fileName]);
    }
}
