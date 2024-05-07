<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

use Illuminate\Support\Facades\Validator;

class UserValidator implements Interfaces\UserValidatorInterface
{
    public function validate(array $data): void
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation error - Rows: ' . $data['num_rows'] . ' ' . $validator->errors()->first());
        }
    }
}
