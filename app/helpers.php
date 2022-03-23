<?php

if (!function_exists('validationResponse') ) {

    function validationResponse($request, $httpCode, $validation, $customErrorCode)
    {
        $data = [
            "success" => 0,
            "code" => $httpCode,
            "meta" => [
                "method" => $request->method(),
                "endpoint" => $request->getPathInfo()
            ],
            "data" => [],
            "errors" => [
                "message" => "The request parameters are incorrect, please make sure to follow the documentation about request parameters of the resource.",
                "code" => $customErrorCode,
                "validation" => $validation
            ],
            "duration" => microtime(true) - LARAVEL_START
        ];
        return response()->json($data, $httpCode);
    }
}

if (!function_exists('successResponse')) {
    function successResponse($request, $httpCode, $data)
    {
        $responseObj = [
            "success" => 1,
            "code" => $httpCode,
            "meta" => [
                "method" => $request->method(),
                "endpoint" => $request->getPathInfo()
            ],
            "data" => $data,
            "errors" => [],
            "duration" => microtime(true) - LARAVEL_START
        ];
        return response()->json($responseObj, $httpCode);
    }
}

if (!function_exists('successResponseWithLimit')) {
    function successResponseWithLimit($request, $httpCode, $data)
    {
        $responseObj = [
            "success" => 1,
            "code" => $httpCode,
            "meta" => [
                "method" => $request->method(),
                "endpoint" => $request->getPathInfo(),
                "limit" => $request->has('limit') ? $request->limit : 30,
                "offset" => $request->has('offset') ? $request->offset : 0
            ],
            "data" => $data,
            "errors" => [],
            "duration" => microtime(true) - LARAVEL_START
        ];
        return response()->json($responseObj, $httpCode);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($request, $httpCode, $errorMessage, $customErrorCode)
    {
        $data = [
            "success" => 0,
            "code" => $httpCode,
            "meta" => [
                "method" => $request->method(),
                "endpoint" => $request->getPathInfo()
            ],
            "data" => [],
            "errors" => [
                "message" => $errorMessage,
                "code" => $customErrorCode,
            ],
            "duration" => microtime(true) - LARAVEL_START
        ];
        return response()->json($data, $httpCode);
    }
}

if (!function_exists('getValidationErrorMessages')) {
    function getValidationErrorMessages($validator)
    {
        $errors = $validator->errors()->getMessages();
        $obj = $validator->failed();
        $validation = [];
        foreach ($obj as $input => $rules) {
            $tmp["attribute"] = $input;
            $tmp["error"] = [];
            $keys = array_keys($rules);
            foreach ($keys as $key) {
                array_push($tmp['error'], [
                    "key" => strtolower($key),
                    "message" => $errors[$input][0]
                ]);
            }
            array_push($validation, $tmp);
        }

        return $validation;

    }
}
