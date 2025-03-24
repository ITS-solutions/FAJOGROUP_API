<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponseService
{
    /**
     * Genera una respuesta exitosa.
     *
     * @param mixed $data
     * @param string|null $message
     * @return JsonResponse
     */
    public function success($data, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Genera una respuesta de error.
     *
     * @param string $message
     * @param int $code
     * @param mixed|null $data
     * @return JsonResponse
     */
    public function error(string $message, int $code = 400, $data = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
