<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions;

use Exception;

class ValidationException extends Exception
{
    /**
     * The array of errors.
     *
     * @var array
     */
    public $errors;

    /**
     * Create a new exception instance.
     *
     * @param  array  $errors
     * @return void
     */
    public function __construct(object $response)
    {
        $this->message = $response->message;
        $this->errors = $response->errors ?? [];
    }

    /**
     * The array of errors.
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
}
