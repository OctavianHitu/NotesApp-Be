<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CreateNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required'],
            'name' => ['required', 'string',],
            'body' => ['required', 'string', 'min:3', 'max:300'],
            'image' => ['required', 'string'],
            'updated_at' => ['required'],
            'created_at' => ['required'],
        ];
    }
}
