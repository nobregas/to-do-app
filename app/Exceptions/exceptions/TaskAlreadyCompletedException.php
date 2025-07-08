<?php

namespace App\Exceptions\exceptions;

use Exception;
use Illuminate\Http\Request;

class TaskAlreadyCompletedException extends ApiException
{
    public function __construct()
    {
        parent::__construct("Task already completed", 409);
    }

}
