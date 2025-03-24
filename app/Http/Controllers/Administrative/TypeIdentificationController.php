<?php

namespace App\Http\Controllers\Administrative;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrative\TypeIdentification\StoreTypeIdentificationRequest;
use App\Http\Requests\Administrative\TypeIdentification\UpdateTypeIdentificationRequest;
use App\Models\TypeIdentification;

class TypeIdentificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TypeIdentification::paginate(10);
        return ApiResponse::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeIdentificationRequest $request)
    {
        $item = TypeIdentification::create($request->all());
        return ApiResponse::success($item, 'Tipo de identificacion creado correctamente', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeIdentification $typeIdentification)
    {
        return ApiResponse::success($typeIdentification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeIdentificationRequest $request, TypeIdentification $typeIdentification)
    {
        $typeIdentification->update($request->all());
        return ApiResponse::success($typeIdentification, 'Tipo de identificacion actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeIdentification $typeIdentification)
    {
        $typeIdentification->delete();
        return ApiResponse::success(null, 'Tipo de identificacion eliminado correctamente');
    }
}
