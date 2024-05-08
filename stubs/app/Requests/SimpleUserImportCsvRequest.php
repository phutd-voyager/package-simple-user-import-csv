<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpleUserImportCsvRequest extends FormRequest
{
    private const MAX_FILE_SIZE = 4096;
    private const ALLOWED_MIME_TYPES = ['text/csv', 'text/plain', 'application/csv'];

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => [
                'required',
                'file',
                'max:' . self::MAX_FILE_SIZE,
                function ($attribute, $value, $fail) {
                    $fileMimeType = $value->getMimeType();

                    if (!in_array($fileMimeType, self::ALLOWED_MIME_TYPES)) {
                        $fail('The ' . $attribute . ' must be a file of type: csv.');
                    }
                },
            ],
        ];
    }
}
