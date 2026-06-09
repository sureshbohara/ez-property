<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $routeUser = $this->route('user');
        $adminId = is_object($routeUser) ? $routeUser->id : $routeUser;
        return [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($adminId)],
            'password'  => $adminId ? ['nullable', 'min:8', 'confirmed'] : ['required', 'min:8', 'confirmed'],
            'role_id'   => ['required', 'exists:roles,id'],
            'address'   => ['nullable', 'string', 'max:500'],
            'mobile'    => ['nullable', 'string', 'max:20'],
            'image'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gender'    => ['nullable', Rule::in(['male', 'female', 'other'])],
            'details'   => ['nullable', 'string'],
            'status'    => ['nullable', 'boolean'],
            'order_level' => ['nullable', 'integer', 'min:0'],
        ];
    }
    public function messages(): array
    {
        return [
            'email.unique'         => 'This email is already registered',
            'password.min'         => 'Password must be at least 8 characters',
            'password.confirmed'   => 'Password confirmation does not match',
            'role_id.exists'       => 'Selected role does not exist',
        ];
    }
}