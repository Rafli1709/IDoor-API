<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryAksesStoreRequest extends FormRequest
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
            'imei_alat' => ['required', 'string', 'exists:alat,imei'],
            'status_pintu' => ['required', 'string', 'max:255'],
            'password' => ['required'],
            'imei_akses' => ['required', 'string'],
            'device_model' => ['required', 'string'],
        ];
    }
}
