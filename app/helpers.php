<?php

if (!function_exists('api_success')) {
    function api_success($data = null, $msg = 'response success')
    {
        return response()->json([
            'status' => 'success',
            'message' => $msg,
            'data' => $data
        ]);
    }
}

if (!function_exists('api_errors')) {
    function api_errors($data = null, $msg = 'response errors')
    {
        return response()->json([
            'status' => 'errors',
            'message' => $msg,
            'errors' => $data
        ]);
    }
}

if (!function_exists('api_validation_errors')) {
    function api_validation_errors($errors = null, $msg = 'The given data was invalid.')
    {
        return response()->json([
            'message' => $msg,
            'errors' => $errors
        ], 422);
    }
}

