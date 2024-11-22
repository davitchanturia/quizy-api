<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
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
            'info.title' => 'required|string|max:255',
            'info.description' => 'required|string',
            'info.category' => 'required|integer|exists:quiz_categories,id',
            'info.difficulty' => 'required|string|in:easy,medium,hard',
            'questions' => 'required|array|min:1',
            'questions.*.content' => 'required|string',
            'questions.*.answers' => 'required|array|min:2',
            'questions.*.answers.*.content' => 'required|string',
            'questions.*.answers.*.is_correct' => 'required|boolean',
        ];
    }

    /**
     * Custom messages for validation errors (optional).
     *
     * @return array
     */
    public function messages()
    {
        return [
            'info.title.required' => 'The quiz title is required.',
            'info.category.exists' => 'The selected category is invalid.',
            'questions.*.content.required' => 'Each question must have content.',
            'questions.*.answers.min' => 'Each question must have at least two answers.',
        ];
    }
}
