<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WriterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|min:3|max:255',
            'email' => 'nullable|string|email|max:255',
            'registered_at'=> 'nullable|date',
        //
        ];
    }
}

