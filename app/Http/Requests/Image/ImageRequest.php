<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ImageRequest extends FormRequest
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
        $filesCount = count($this->images);

        $isExceedsLimit = auth()->user()->profile->images->count() + $filesCount > 5;

        if ($isExceedsLimit) {
            throw ValidationException::withMessages(['message' => 'images count exceeds the limit']);
        }

        return [
            'images' => ['required', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:png,jpg,jpeg,gif,webp', 'max:8192'],
        ];
    }
}
