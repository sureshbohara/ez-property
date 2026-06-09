<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $faqId = $this->route('faq')?->id;
        
        return [
            'display_on'  => 'required|string|max:100',
            'question'    => 'required|string|max:500',
            'answer'      => 'required|string',
            'order_level' => 'nullable|integer|min:0',
            'status'      => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'Please enter the FAQ question.',
            'answer.required'   => 'Please enter the answer.',
            'display_on.required' => 'Please select where to display this FAQ.',
        ];
    }
}