<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvatarRequest extends FormRequest
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
        // validation: https://laravel.com/docs/10.x/validation#quick-writing-the-validation-logic
        return [
            'avatar' => ['required', 'image'], //avatar field has to be an image, usage: https://laravel.com/docs/10.x/validation#available-validation-rules
        ];
    }
}
