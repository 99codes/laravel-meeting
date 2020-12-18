<?php

namespace Nncodes\Meeting\Contracts;

interface Provider
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public function facadeAccessor(): string;

    /**
     * Get a new resource instance.
     *
     * @return Resource
     */
    public function resource(): Resource;

    /**
     * Get a new dispatcher instance.
     *
     * @return Dispatcher
     */
    public function dispatcher(): Dispatcher;
}
