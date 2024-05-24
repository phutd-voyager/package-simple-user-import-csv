<?php

namespace VoyagerInc\SimpleUserImportCsv\Constants;

class ValidationConstant
{
    public const RULES_DEFAULT = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ];
}