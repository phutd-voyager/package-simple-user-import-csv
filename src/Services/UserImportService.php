<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserImportService implements Interfaces\UserImportServiceInterface
{
    public function import(array $userData)
    {
        foreach ($userData as $data) {
            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
            ]);

            if ($validator->fails()) {
                throw new \Exception('Validation error: ' . $validator->errors()->first());
            }

            User::create($data);
        }

        return true;
    }
}
