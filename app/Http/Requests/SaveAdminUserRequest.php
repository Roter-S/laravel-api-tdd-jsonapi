<?php

namespace App\Http\Requests;

use App\Enums\UserStatus;
use App\Rules\Slug;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
        $userId = $this->route('admin_user');
        return [
            'data.attributes.slug' => [
                'required',
                'alpha_dash',
                new Slug(),
                Rule::unique('users', 'slug')->ignore($userId)
            ],
            'data.attributes.name' => ['required', 'string'],
            'data.attributes.last_name' => ['required', 'string'],
            'data.attributes.email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'data.attributes.password' => [
                Rule::requiredIf(!$userId),
                'string'
            ],
            'data.attributes.date_of_birth' => ['required', 'date'],
            'data.attributes.phone_number' => ['required', 'string'],
            'data.attributes.status' => ['required', new Enum(UserStatus::class)],
            'data.attributes.roles' => ['required', 'array'],
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
