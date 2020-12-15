<?php

namespace Nncodes\Meeting;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nncodes\Meeting\Meeting
 */
class MeetingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-meeting';
    }
}
