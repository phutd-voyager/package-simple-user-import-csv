<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

class CsvFileReader
{
    public function read($filePath, $skipHeader = true)
    {
        $handle = fopen($filePath, "r");

        if ($skipHeader) {
            fgetcsv($handle);
        }

        $data = [];
        while (($row = fgetcsv($handle, 1000, ",")) !== false) {
            $data[] = $row;
        }

        fclose($handle);

        return $data;
    }
}
