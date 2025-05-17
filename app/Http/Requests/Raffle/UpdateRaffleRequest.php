<?php

namespace App\Http\Requests\Raffle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRaffleRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image_file' => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'sometimes|integer|min:0',
            'status' => 'sometimes|in:0,1',
            'end_date' => 'sometimes|date|after:today',
            'sale_type' => 'sometimes|in:1,2,3',
            'raffle_category_id' => 'sometimes|exists:raffle_categories,id',
            'lottery_id' => 'sometimes|exists:lotteries,id'
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
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'image_file.required' => 'La imagen es obligatoria.',
            'image_file.image' => 'El archivo debe ser una imagen.',
            'image_file.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp.',
            'image_file.max' => 'La imagen no debe exceder los 2MB.',
            'price.required' => 'El precio es obligatorio.',
            'price.integer' => 'El precio debe ser un número entero.',
            'price.min' => 'El precio debe ser al menos 0.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser 0 o 1.',
            'end_date.required' => 'La fecha de finalización es obligatoria.',
            'end_date.date' => 'La fecha de finalización debe ser una fecha valida.',
            'end_date.after' => 'La fecha de finalización debe ser posterior a hoy.',
            'sale_type.required' => 'El tipo de venta es obligatorio.',
            'sale_type.in' => 'El tipo de venta debe ser 1, 2 o 3.',
            'raffle_category_id.required' => 'La categoría de la rifa es obligatoria.',
            'raffle_category_id.exists' => 'La categoría de la rifa seleccionada no es válida.',
            'lottery_id.required' => 'La lotería es obligatoria.',
            'lottery_id.exists' => 'La lotería seleccionada no es válida.',
        ];
    }
}
