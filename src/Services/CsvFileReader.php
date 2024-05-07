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

        while (($row = fgetcsv($handle, 1000, ",")) !== false) {
            if (count($row) >= 3) {
                $data[] = [
                    'name' => $row[0],
                    'email' => $row[1],
                    'password' => $row[2],
                ];
            }
        }

        fclose($handle);

        return $data;
    }
}
