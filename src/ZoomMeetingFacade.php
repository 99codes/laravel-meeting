<?php

namespace Nncodes\ZoomMeeting;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nncodes\ZoomMeeting\ZoomMeeting
 */
class ZoomMeetingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-zoom-meeting';
    }
}
