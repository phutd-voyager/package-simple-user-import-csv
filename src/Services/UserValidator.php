<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

use Illuminate\Support\Facades\Validator;
use VoyagerInc\SimpleUserImportCsv\Constants\ValidationConstant;

class UserValidator implements Interfaces\UserValidatorInterface
{
    protected $rules;

    public function __construct()
    {
        $this->rules = config('user_import_csv.user_validator.rules', ValidationConstant::RULES_DEFAULT);
    }

    public function validate(array $data): void
    {
        $validator = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            throw new \Exception('Validation error - Rows: ' . $data['num_rows'] . ' ' . $validator->errors()->first());
        }
    }
}
