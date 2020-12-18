<?php

namespace Nncodes\Meeting\Providers\Database;

use Nncodes\Meeting\Contracts\Provider as Contract;

class Provider implements Contract
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public function facadeAccessor(): string
    {
        return 'database';
    }

    /**
     * Get a new resource instance
     *
     * @return \Nncodes\Meeting\Providers\Database\Resource
     */
    public function resource(): Resource
    {
        return new Resource;
    }

    /**
    * Get a new dispatcher instance
    *
    * @return \Nncodes\Meeting\Providers\Database\Dispatcher
    */
    public function dispatcher(): Dispatcher
    {
        return new Dispatcher;
    }
}
