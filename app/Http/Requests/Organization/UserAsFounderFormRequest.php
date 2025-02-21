<?php

namespace App\Http\Requests\Organization;

use Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserAsFounderFormRequest extends FormRequest
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
            'is_founder' => 'boolean',
            'organization.founder.first_name' => 'required_if:is_founder,true|string|max:255',
            'organization.founder.last_name' => 'required_if:is_founder,true|string|max:255',
            'organization.founder.phone' => 'required_if:is_founder,true|string|max:255',
            'organization.founder.email' => 'required_if:is_founder,true|string|lowercase|email|max:255',
            'organization.founder.password' => ['required_if:is_founder,true', 'confirmed'],

            'organization.creation.name' => ['required_if:is_founder,true', 'string', 'max:255'],
            'organization.creation.type_organization_id' => ['required_if:is_founder,true', 'integer'],
            'organization.creation.sub_type_organization_id' => ['required_if:is_founder,true', 'integer'],
            'organization.creation.organization_role' => ['required_if:is_founder,true', 'array']
        ];
    }
}
