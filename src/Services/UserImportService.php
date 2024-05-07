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
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                throw new \Exception('Validation error - Row: ' . $data['num_rows'] . ': ' . $validator->errors()->first());
            }

            $data['password'] = bcrypt($data['password']);

            User::create($data);
        }

        return true;
    }
}
