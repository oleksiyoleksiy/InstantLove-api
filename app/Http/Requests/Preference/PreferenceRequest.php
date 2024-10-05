<?php

namespace App\Http\Requests\Preference;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PreferenceRequest extends FormRequest
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
            'age' => [
                'integer',
                'required_without_all:min_age,max_age',
                'min:14',
                'max:40',
            ],
            'min_age' => [
                'integer',
                'nullable',
                'required_without:age',
                'lt:max_age',
            ],
            'max_age' => [
                'integer',
                'nullable',
                'required_without:age',
                'gt:min_age',
            ],
            'gender' => [
                'required',
                'string',
                'in:male,female,all',
            ],
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->age && ($this->min_age || $this->max_age)) {
                $validator->errors()->add('message', 'you need to select a range or a specific value for age');
            }

            if (auth()->user()->preference && $this->route()->named('preference.store')) {
                $validator->errors()->add('message', 'user already have a preferences');
            }
        });
    }
}
