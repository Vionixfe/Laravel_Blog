<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "is_confirm" => "nullable|in:0,1", // Hanya untuk konfirmasi
        ];
    }
}
