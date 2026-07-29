<?php

namespace App\Http\Requests\Admin;

use App\Models\Feedback;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([Feedback::STATUS_NEW, Feedback::STATUS_REVIEWED, Feedback::STATUS_RESOLVED])],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
