<?php

namespace App\Exceptions\exceptions;

class UnauthorizedException extends ApiException
{
    public function __construct()
    {
        parent::__construct(
            statusCode: 401,
            message: "Unauthorized",
        );
    }
}
