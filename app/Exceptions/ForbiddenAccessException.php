<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ForbiddenAccessException extends Exception
{
    /**
     * @param string|null $message
     */
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? __('client.Access Forbidden'), Response::HTTP_FORBIDDEN);
    }
}

