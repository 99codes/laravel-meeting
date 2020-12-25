<?php

namespace Nncodes\Meeting\Providers\Zoom\Exceptions;

use Exception;

class TooManyRequestsException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param  array  $errors
     * @return void
     */
    public function __construct(object $response)
    {
        $this->message = $response->message;
    }
}
