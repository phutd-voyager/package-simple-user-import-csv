<?php

namespace VoyagerInc\SimpleUserImportCsv\Services\Interfaces;

interface CsvWritterInterface
{
    public function download(array $data = []);
}
