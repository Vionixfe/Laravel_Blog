<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditWriterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "is_verified" => "nullable|in:0,1", // Hanya untuk konfirmasi
        ];
    }
}
