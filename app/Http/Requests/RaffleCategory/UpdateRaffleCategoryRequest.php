<?php

namespace App\Http\Requests\RaffleCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRaffleCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:raffle_categories,name,' . $this->route('category')->id,
            'description' => 'nullable|string|max:255',
            'status' => 'required|numeric|in:0,1',
            'icon' => 'nullable|string|max:255',
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
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no puede tener más de 255 caracteres.',
            'status.required' => 'El estado es obligatorio.',
            'status.numeric' => 'El estado debe ser un número.',
            'status.in' => 'El estado debe ser 0 o 1.',
            'icon.string' => 'El icono debe ser una cadena de texto.',
            'icon.max' => 'El icono no puede tener más de 255 caracteres.',
        ];
    }
}
