<?php

namespace Nncodes\Meeting;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Nncodes\Meeting\Meeting usingProvider($string $provider) Set the meeting provider
 * @method static \Nncodes\Meeting\Meeting withTopic(string $topic) Set the topic of the meeting
 * @method static \Nncodes\Meeting\Meeting startingAt(\Carbon\Carbon $startTime) Set the topic of the meeting
 * @method static \Nncodes\Meeting\Meeting taking(int $minutes) Set the duration in minutes of the meeting
 * @method static \Nncodes\Meeting\Meeting placedBy(\Nncodes\Meeting\Contracts\Place $place) Set the place of the meeting
 * @method static \Nncodes\Meeting\Meeting scheduledBy(\Nncodes\Meeting\Contracts\Scheduler $scheduler) Set the scheduler of the meeting
 * @method static \Nncodes\Meeting\Meeting forHost(\Nncodes\Meeting\Contracts\Host $host) Set the host of the meeting
 *
 * @see \Nncodes\Meeting\Meeting
 */
class MeetingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return Meeting::class;
    }
}
