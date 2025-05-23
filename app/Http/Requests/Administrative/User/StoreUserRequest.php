<?php

namespace App\Http\Requests\Administrative\User;

use App\Facades\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'identification' => 'required|string|max:255|unique:users,identification',
            'phone_number' => 'required|string|max:255|unique:users,phone_number',
            'address' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'type_identification_id' => 'required|exists:type_identifications,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
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
            'lastname.required' => 'El campo apellido es obligatorio.',
            'lastname.string' => 'El campo apellido debe ser una cadena de texto.',
            'lastname.max' => 'El campo apellido no debe exceder los 255 caracteres.',
            'identification.required' => 'El campo identificación es obligatorio.',
            'identification.string' => 'El campo identificación debe ser una cadena de texto.',
            'identification.max' => 'El campo identificación no debe exceder los 255 caracteres.',
            'identification.unique' => 'La identificación ya ha sido registrada.',
            'phone_number.required' => 'El campo número de teléfono es obligatorio.',
            'phone_number.string' => 'El campo número de teléfono debe ser una cadena de texto.',
            'phone_number.max' => 'El campo número de teléfono no debe exceder los 255 caracteres.',
            'phone_number.unique' => 'El número de teléfono ya ha sido registrado.',
            'address.string' => 'El campo dirección debe ser una cadena de texto.',
            'address.max' => 'El campo dirección no debe exceder los 255 caracteres.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.string' => 'El campo correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El campo correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El campo correo electrónico no debe exceder los 255 caracteres.',
            'email.unique' => 'El correo electrónico ya ha sido registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'El campo contraseña debe ser una cadena de texto.',
            'password.min' => 'El campo contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'type_identification_id.required' => 'El campo tipo de identificación es obligatorio.',
            'type_identification_id.exists' => 'El tipo de identificación seleccionado no es válido.',
            'roles.required' => 'Debes seleccionar al menos un rol.',
            'roles.array' => 'El formato de los roles seleccionados no es válido.',
            'roles.*.exists' => 'Uno o más de los roles seleccionados no existen en el sistema.',
        ];
    }
}
