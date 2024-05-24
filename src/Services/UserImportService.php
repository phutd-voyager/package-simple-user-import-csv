<?php

namespace VoyagerInc\SimpleUserImportCsv\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        $dataCreate = [];

        foreach ($userData as $data) {
            $this->validator->validate($data);

            $data['password'] = Hash::make($data['password']);

            $dataCreate[] = $data;
        }

        return User::insert($dataCreate);
    }
}
