<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions;

use Exception;

class ConflictException extends Exception
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
