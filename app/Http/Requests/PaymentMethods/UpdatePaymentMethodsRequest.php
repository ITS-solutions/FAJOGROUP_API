<?php

namespace App\Http\Requests\PaymentMethods;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodsRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:payment_methods,name,' . $this->route('payment_method')->id,
            'status' => 'required|numeric|in:0,1',
            'is_online' => 'required|numeric|in:0,1',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'name.unique' => 'El nombre ya está en uso.',
            'status.required' => 'El estado es obligatorio.',
            'status.numeric' => 'El estado debe ser un número.',
            'status.in' => 'El estado debe ser 0 o 1.',
            'is_online.required' => 'El campo is_online es obligatorio.',
            'is_online.numeric' => 'El campo is_online debe ser un número.',
            'is_online.in' => 'El campo is_online debe ser 0 o 1.',
        ];
    }
}
