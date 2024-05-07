<?php

namespace VoyagerInc\SimpleUserImportCsv\Services\Interfaces;

interface CsvFileReaderInterface
{
    public function read($filePath, $skipHeader = true);
}
