<?php

use \Illuminate\Http\JsonResponse;

function validationErrors($errors, $message = null): JsonResponse
{
    $data = [
        'status' => 'validations',
        'message' => (empty($message)) ? __('response.invalid_data') : $message,
        'errors' => $errors,
    ];

    return response()->json($data, 422);
}
