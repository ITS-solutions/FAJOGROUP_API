<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\RaffleCategory\StoreRaffleCategoryRequest;
use App\Http\Requests\RaffleCategory\UpdateRaffleCategoryRequest;
use App\Models\RaffleCategory;

class RaffleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = RaffleCategory::paginate(10);
        return ApiResponse::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRaffleCategoryRequest $request)
    {
        $item = RaffleCategory::create($request->all());
        return ApiResponse::success($item, 'Rifa creada correctamente', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RaffleCategory $category)
    {
        return ApiResponse::success($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRaffleCategoryRequest $request, RaffleCategory $category)
    {
        $category->update($request->all());
        return ApiResponse::success($category, 'Rifa actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RaffleCategory $category)
    {
        $category->delete();
        return ApiResponse::success(null, 'Rifa eliminada correctamente');
    }
}
