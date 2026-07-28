<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:packages,code'],
            'monthly_price' => ['required', 'numeric', 'min:0'],
            'yearly_price' => ['nullable', 'numeric', 'min:0'],
            'menu_limit' => ['nullable', 'integer', 'min:0'],
            'category_limit' => ['nullable', 'integer', 'min:0'],
            'storage_limit_mb' => ['required', 'integer', 'min:1'],
            'team_limit' => ['required', 'integer', 'min:1'],
            'language_limit' => ['required', 'integer', 'min:1'],
            'has_statistics' => ['sometimes', 'boolean'],
            'has_custom_theme' => ['sometimes', 'boolean'],
            'remove_branding' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
