<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveAdminUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('patch')) {
            return [
                'data.attributes.slug' => ['required', 'string'],
                'data.attributes.name' => ['required', 'string'],
                'data.attributes.last_name' => ['required', 'string'],
                'data.attributes.email' => ['required', 'email'],
                'data.attributes.password' => ['nullable', 'string'],
                'data.attributes.date_of_birth' => ['required', 'date'],
                'data.attributes.phone_number' => ['required', 'string'],
                'data.attributes.status' => ['required', 'boolean'],
                'data.attributes.roles' => ['required', 'string'],
                'data.attributes.instrument_id' => ['nullable', 'integer', 'exists:instruments,id'],
                'data.attributes.voice_id' => ['nullable', 'integer', 'exists:voices,id'],
                'data.attributes.entity_id' => ['nullable', 'integer', 'exists:entities,id']
            ];
        }

        return [
            'data.attributes.slug' => ['required', 'string', 'unique:users,slug'],
            'data.attributes.name' => ['required', 'string'],
            'data.attributes.last_name' => ['required', 'string'],
            'data.attributes.email' => ['required', 'email', 'unique:users,email'],
            'data.attributes.password' => ['required', 'string'],
            'data.attributes.date_of_birth' => ['required', 'date'],
            'data.attributes.phone_number' => ['required', 'string'],
            'data.attributes.status' => ['required', 'boolean'],
            'data.attributes.roles' => ['required', 'string'],
            'data.attributes.instrument_id' => ['nullable', 'integer', 'exists:instruments,id'],
            'data.attributes.voice_id' => ['nullable', 'integer', 'exists:voices,id'],
            'data.attributes.entity_id' => ['nullable', 'integer', 'exists:entities,id']
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return parent::validated()['data']['attributes'];
    }
}
