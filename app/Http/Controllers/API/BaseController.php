<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    protected function sendResponse($result, $message, $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
            'timestamp' => now(),
        ];

        return response()->json($response, $code);
    }

    protected function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
            'status' => $code,
            'timestamp' => now(),
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    protected function validate(array $data, array $rules): \Illuminate\Validation\Validator
    {
        return Validator::make($data, $rules);
    }
}
