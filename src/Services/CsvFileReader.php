<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

class CsvFileReader implements Interfaces\CsvFileReaderInterface
{
    public function read($filePath, $skipHeader = true)
    {
        $handle = fopen($filePath, "r");

        $data = [];
        $numRows = 1;

        if ($skipHeader) {
            fgetcsv($handle);
        } else {
            $data[] = $this->readRow($handle, $numRows);
            $numRows++;
        }

        $limitLength = config('user_import_csv.csv_reader.limit_length', 1000);
        $headerFormat = config('user_import_csv.csv_reader.header_format', ['name', 'email', 'password']);

        while (($row = fgetcsv($handle, $limitLength, ",")) !== false) {
            if (count($row) === count($headerFormat)) {
                $data[] = [
                    'name' => $row[0],
                    'email' => $row[1],
                    'password' => $row[2],
                    'num_rows' => $numRows,
                ];
            } else {
                fclose($handle);
                throw new \Exception('Wrong number of columns.');
            }
        }

        fclose($handle);

        return $data;
    }

    private function readRow($handle, $numRows)
    {
        $row = fgetcsv($handle);

        if ($row === false) {
            throw new \Exception('Failed to read row.');
        }

        return [
            'name' => $row[0],
            'email' => $row[1],
            'password' => $row[2],
            'num_rows' => $numRows,
        ];
    }
}
