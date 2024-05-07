<?php

namespace VoyagerInc\SimpleUserImportCsv\Services\Interfaces;

interface CsvWriterInterface
{
    public function download(array $data = []);
}
