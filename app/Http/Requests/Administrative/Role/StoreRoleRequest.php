<?php

namespace App\Http\Requests\Administrative\Role;

use App\Facades\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
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
            'permissions.required' => 'Debe seleccionar al menos un permiso.',
            'permissions.array' => 'El campo permisos debe ser un arreglo.',
            'permissions.*.string' => 'Cada permiso debe ser una cadena de texto.',
            'permissions.*.exists' => 'Uno o más de los permisos seleccionados no existen en el sistema.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $permissions = $this->extractAssignedPermissions($this->input('permissions'));

        $this->merge([
            'permissions' => $permissions,
        ]);
    }

    protected function extractAssignedPermissions(array $permissions): array {
        $assignedPermissions = [];

        foreach ($permissions as $permission) {
            if (is_array($permission) && isset($permission['assigned'], $permission['name']) && $permission['assigned'] === true) {
                $assignedPermissions[] = $permission['name'];
            } elseif (is_array($permission)) {
                $assignedPermissions = array_merge($assignedPermissions, $this->extractAssignedPermissions($permission));
            }
        }

        return $assignedPermissions;
    }
}
