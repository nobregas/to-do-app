<?php

namespace App\Exceptions\exceptions;


class ResourceNotFoundException extends ApiException
{
    public function __construct()
    {
        parent::__construct(404, 'Resource not found');
    }
}
