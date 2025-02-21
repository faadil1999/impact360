<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserAsMemberFormRequest extends FormRequest
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
            'is_member' => 'boolean',
            'register.first_name' => 'required_if:is_founder,true|string|max:255',
            'register.last_name' => 'required_if:is_founder,true|string|max:255',
            'register.phone' => 'required_if:is_founder,true|string|max:255',
            'register.email' => 'required_if:is_founder,true|string|lowercase|email|max:255',
            'register.password' => ['required_if:is_founder,true', 'confirmed'],
            'register.roles' => ['required_if:is_member,true', 'array']
        ];
    }
}
