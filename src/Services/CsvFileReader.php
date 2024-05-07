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

        $limitLength = config('simple_user_import_csv.limit_length', 1000);

        while (($row = fgetcsv($handle, $limitLength, ",")) !== false) {
            if (count($row) >= 3) {
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
