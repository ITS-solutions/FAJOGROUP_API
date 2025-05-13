<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\PaymentMethods\StorePaymentMethodsRequest;
use App\Http\Requests\PaymentMethods\UpdatePaymentMethodsRequest;
use App\Models\PaymentMethods;

class PaymentMethodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PaymentMethods::paginate(10);
        return ApiResponse::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentMethodsRequest $request)
    {
        // check if is_online is 1
        if($request->is_online == 1) {
            $exists = PaymentMethods::where('is_online', 1)->exists();

            if($exists) {
                return ApiResponse::error('Ya existe un método de pago online activo', 422);
            }
        }

        $item = PaymentMethods::create($request->all());
        return ApiResponse::success($item, 'Método creado correctamente', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethods $payment_method)
    {
        return ApiResponse::success($payment_method);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodsRequest $request, PaymentMethods $payment_method)
    {
        // check if is_online is 1
        if($request->is_online == 1) {
            $exists = PaymentMethods::where([
                ['is_online', 1],
                ['id', '!=', $payment_method->id]
            ])->exists();

            if($exists) {
                return ApiResponse::error('Ya existe un método de pago online activo', 422);
            }
        }

        $payment_method->update($request->all());
        return ApiResponse::success($payment_method, 'Método actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethods $payment_method)
    {
        $payment_method->delete();
        return ApiResponse::success(null, 'Método eliminado correctamente');
    }
}
