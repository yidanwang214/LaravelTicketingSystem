<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            // title field of form in route(ticket.create) should required and be string, max length should be 255
            // 'title' refers to the 'name' attribute of this input field
            'title' => ['required', 'string', 'max:255'],
            // decription field of form in route(ticket.create) should required and be string
            'description' => ['required', 'string'],
            // attachment field of form in route(ticket.create) is not mandatory, and the format should be any one of jpg, jpeg, png and pdf
            'attachment' => ['sometimes', 'file', 'mimes:jpg,jpeg,png,pdf'],
        ];
    }
}
