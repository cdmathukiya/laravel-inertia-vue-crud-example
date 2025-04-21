<?php

namespace App\Http\Requests;

use App\Helper\CommonHelper;
use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'director' => ['required', 'string', 'max:255'],
            'release_date' => ['required', 'date'],
            'number' => ['required', 'numeric', 'max_digits:15'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable'],
            'description' => ['required', 'string'],
            'status' => ['required'],
        ];

        if (request()->hasFile('image')) {
            $rules['image'] = array_merge(CommonHelper::getImageValidationRule('image'));
        }

        return $rules;
    }
}
