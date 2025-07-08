<?php

namespace App\Exceptions\exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiException extends Exception
{
    protected int $statusCode;

    public function __construct(int $statusCode, string $message = "")
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            "message" => $this->getMessage(),
        ], $this->statusCode);
    }
}
