<?php

namespace App\Http\Requests\Administrative\TypeIdentification;

use App\Facades\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateTypeIdentificationRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        // Obtener el ID del registro que se está actualizando
        $typeIdentificationId = $this->route('type_identification');

        return [
            'name' => [
                'required','string','max:255',
                Rule::unique('type_identifications', 'name')->ignore($typeIdentificationId),
            ],
            'short_name' => [
                'required','string','max:255',
                Rule::unique('type_identifications', 'short_name')->ignore($typeIdentificationId),
            ],
            'alphanumeric' => 'required|boolean',
        ];
    }

    /**
     * Obtiene los mensajes de error personalizados para las reglas de validación.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 255 caracteres.',
            'name.unique' => 'El nombre ya ha sido registrado.',
            'short_name.required' => 'El campo nombre corto es obligatorio.',
            'short_name.string' => 'El campo nombre corto debe ser una cadena de texto.',
            'short_name.max' => 'El campo nombre corto no debe exceder los 255 caracteres.',
            'short_name.unique' => 'El nombre corto ya ha sido registrado.',
            'alphanumeric.required' => 'El campo alfanumérico es obligatorio.',
            'alphanumeric.boolean' => 'El campo alfanumérico debe ser verdadero o falso.',
        ];
    }
}
