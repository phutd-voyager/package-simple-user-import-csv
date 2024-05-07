<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

use Illuminate\Support\Facades\Validator;

class UserValidator implements Interfaces\UserValidatorInterface
{
    protected $rules;

    public function __construct()
    {
        $this->rules = config('simple_user_import_csv.user_validator.rules', [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
    }

    public function validate(array $data): void
    {
        $validator = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            throw new \Exception('Validation error - Rows: ' . $data['num_rows'] . ' ' . $validator->errors()->first());
        }
    }
}
