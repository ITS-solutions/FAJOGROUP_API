<?php

namespace App\Http\Controllers\Administrative;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrative\User\StoreUserRequest;
use App\Http\Requests\Administrative\User\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Muestra una lista paginada de los usuarios.
     */
    public function index()
    {
        $users = User::paginate(10);
        return ApiResponse::success($users);
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        
        // assign roles
        $user->assignRole($request->input('roles'));
        
        return ApiResponse::success($user, 'Usuario creado correctamente', 201);
    }

    /**
     * Muestra la información de un usuario específico.
     */
    public function show(User $user)
    {
        $user->getRoleNames();
        return ApiResponse::success($user);
    }

    /**
     * Actualiza la información de un usuario específico.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        return ApiResponse::success($user, 'Usuario actualizado correctamente');
    }

    /**
     * Elimina un usuario específico de la base de datos.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return ApiResponse::success(null, 'Usuario eliminado correctamente');
    }
}
