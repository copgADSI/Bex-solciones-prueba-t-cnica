<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitRequest extends FormRequest
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
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Name is required',
            'customer_email.required' => 'Email is required',
            'latitude.required' => 'Latitude is required',
            'latitude.numeric' => 'Latitude is invalid',
            'longitude.required' => 'Longitude is required',
            'longitude.numeric' => 'Longitude is invalid',
        ];
    }
}
