<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

use App\Models\User;
use VoyagerInc\SimpleUserImportCsv\Services\Interfaces\UserValidatorInterface;

class UserImportService implements Interfaces\UserImportServiceInterface
{
    protected $validator;

    public function __construct(UserValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function import(array $userData)
    {
        foreach ($userData as $data) {
            $this->validator->validate($data);

            $data['password'] = bcrypt($data['password']);

            User::create($data);
        }

        return true;
    }
}
