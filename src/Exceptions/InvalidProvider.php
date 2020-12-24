<?php

namespace Nncodes\Meeting\Exceptions;

class InvalidProvider extends \Exception
{

    /**
     * @var string
     */
    protected string $provider;

    /**
     * Provides a static method to create a new InvalidProvider Exception
     *
     * @param string $provider
     * @return self
     */
    public static function create(string $provider): self
    {
        return new static(
            'The provider `%s` is not present in the providers list of the config file `%s`',
            $provider
        );
    }

    /**
     * Create a new instance of InvalidProvider exception
     *
     * @param string $message
     */
    public function __construct(string $message, string $provider)
    {
        $this->message = sprintf(
            $message,
            $provider,
            config_path('meeting')
        );

        $this->provider = $provider;
    }
   
    /**
     * Get the not found provider name
     *
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }
}
