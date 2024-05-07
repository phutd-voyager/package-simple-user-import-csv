<?php

namespace VoyagerInc\SimpleUserImportCsv\Services\Interfaces;

interface UserValidatorInterface
{
    public function validate(array $data): void;
}
