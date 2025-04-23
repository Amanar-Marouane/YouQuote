<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Console\Input\Input;

class QuoteUpdateRequest extends FormRequest
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
        $rules = [
            'type' => ['required', 'string', 'exists:types,type'],
            'quote' => ['required', 'string', 'max:1000'],
            'author' => ['required', 'string'],
            'category_id' => ['required', 'array', 'min:1'],
            'category_id.*' => ['exists:categories,id'],
        ];

        $typeSpecificRules = [
            'Book' => [
                'year' => 'required|integer|max:' . date('Y'),
                'publisher' => 'required|string|max:255',
            ],
            'Article' => [
                'page_range' => 'required|integer|min:1',
                'issue' => 'required|string|max:100',
                'volume' => 'required|string|max:100',
                'year' => 'required|integer|max:' . date('Y'),
            ],
            'Website' => [
                'url' => 'required|url',
            ],
        ];

        $type = $this->input('type');
        if (isset($typeSpecificRules[$type])) {
            $rules = array_merge($rules, $typeSpecificRules[$type]);
        }

        return $rules;
    }
}
