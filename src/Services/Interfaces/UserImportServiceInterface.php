<?php

namespace VoyagerInc\SimpleUserImportCsv\Services\Interfaces;

interface UserImportServiceInterface
{
    public function import(array $userData);
}
