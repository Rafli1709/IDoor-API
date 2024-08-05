<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HakAksesStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'alat_id' => ['required', 'integer', 'exists:alat,id'],
            'batas_waktu' => ['nullable', 'date_format:Y-m-d H:i:s']
        ];
    }
}
