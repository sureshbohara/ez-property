<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Role;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $superAdminId = Role::where('name', 'super_admin')->value('id');
        return [
            'role_id' => ['required', 'integer', 'exists:roles,id', Rule::notIn([$superAdminId])],
            'permission' => 'required|array',
            'permission.*' => 'array',
            'permission.*.*' => 'in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'role_id.required' => 'Please select a role.',
            'permission.required' => 'Permissions configuration is required.',
        ];
    }
}