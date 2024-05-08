<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

class CsvFileReader implements Interfaces\CsvFileReaderInterface
{
    public function read($filePath, $skipHeader = true)
    {
        $handle = fopen($filePath, "r");

        if ($skipHeader) {
            fgetcsv($handle);
        }

        $data = [];
        $numRows = 1;

        $limitLength = config('simple_user_import_csv.csv_reader.limit_length', 1000);
        $headerFormat = config('simple_user_import_csv.csv_reader.header_format', ['name', 'email', 'password']);

        while (($row = fgetcsv($handle, $limitLength, ",")) !== false) {
            if (count($row) === count($headerFormat)) {
                $data[] = [
                    'name' => $row[0],
                    'email' => $row[1],
                    'password' => $row[2],
                    'num_rows' => $numRows,
                ];
            }
        }

        fclose($handle);

        return $data;
    }
}
