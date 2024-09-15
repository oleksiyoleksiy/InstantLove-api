<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'images.*' => ['image', 'mimetypes:png,jpg,jpeg,gif', 'max:8192'],
            'name' => ['required', 'string', 'max:20'],
            'location' => ['required', 'string', 'max:83'],
            'gender' => ['required', 'string', 'in:male,female'],
            'age' => ['required', 'integer', 'min:14', 'max:40']
        ];
    }
}
