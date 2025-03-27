<?php

namespace App\Http\Controllers\Administrative;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrative\Role\StoreRoleRequest;
use App\Http\Requests\Administrative\Role\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::paginate(10);
        return ApiResponse::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $item = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        $item->syncPermissions($request->permissions);

        return ApiResponse::success($item, 'Rol creado correctamente', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $asignedPermissions = $role->permissions()->pluck('name')->toArray();
        $groupedPermissions = $this->getGroupedPermissions($asignedPermissions);

        $role['permissions'] = $groupedPermissions;
        
        return ApiResponse::success($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->syncPermissions($request->permissions);
        
        return ApiResponse::success($role, 'Rol actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return ApiResponse::success(null, 'Rol eliminado correctamente');
    }

    /**
     * Get the permissions grouped by their parts.
     *
     * @return array|null
     */
    private function getGroupedPermissions($asignedPermissions)
    {
        $permissions = Permission::all();
        if($permissions->isEmpty()) {
            return null;
        }

        $groupedPermissions = [];

        foreach ($permissions as $permission) {
            $parts = explode('.', $permission->name);
            $currentLevel = &$groupedPermissions;

            foreach ($parts as $part) {
                if (!isset($currentLevel[$part])) {
                    $currentLevel[$part] = [];
                }
                $currentLevel = &$currentLevel[$part];
            }

            // Assign the permission name to the deepest level
            $currentLevel = [
                'name' => $permission->name,
                'assigned' => in_array($permission->name, $asignedPermissions)
            ];
        }

        return $groupedPermissions;
    }

    /**
     * Get the permissions grouped by their parts.
     */
    public function tree()
    {
        $groupedPermissions = $this->getGroupedPermissions([]);
        return ApiResponse::success($groupedPermissions);
    }
}
