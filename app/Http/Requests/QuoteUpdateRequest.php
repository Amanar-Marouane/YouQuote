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
        $typeRules = [
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
        $mainColumnsRules = [
            'type' => ['required', 'string', 'exists:types,type'],
            'quote' => ['required', 'string', 'max:1000'],
            'author' => ['required', 'string'],
        ];
        $mainColumns = ['author', 'type_id', 'quote'];
        $rules = [];

        foreach ($mainColumns as $column) {
            if ($this->input($column)) {
                $rules[$column] = $mainColumnsRules[$column];
            }
        }

        $rules['type'] = 'required|string|exists:types,type';
        $type = $this->input('type');
        if (isset($typeRules[$type])) {
            $rules = array_merge($rules, $typeRules[$type]);
        }


        $content = $this->except(array_keys(array_merge($rules, ['type'])));

        foreach ($content as $key => $value) {
            if (isset($typeRules[$key])) {
                $rules[$key] = $typeRules[$key];
            }
        }
        return $rules;
    }
}
