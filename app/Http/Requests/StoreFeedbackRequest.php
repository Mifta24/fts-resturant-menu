<?php

namespace App\Http\Requests;

use App\Models\Feedback;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in([Feedback::TYPE_BUG, Feedback::TYPE_SUGGESTION, Feedback::TYPE_OTHER])],
            'message' => ['required', 'string', 'max:2000'],
        ];
    }
}
