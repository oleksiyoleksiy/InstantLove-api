<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
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
            'images' => ['required', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:png,jpg,jpeg,gif,webp', 'max:8192'],
            'name' => ['required', 'string', 'max:20'],
            'location' => ['required', 'string', 'max:83'],
            'gender' => ['required', 'string', 'in:male,female'],
            'age' => ['required', 'integer', 'min:14', 'max:40']
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (auth()->user()->profile) {
                $validator->errors()->add('message', 'you need to select a range or a specific value for age');
            }
        });
    }
}
