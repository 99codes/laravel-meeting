<?php

namespace Nncodes\Meeting\Events;

use Illuminate\Queue\SerializesModels;
use Nncodes\Meeting\Models\Meeting;

class MeetingUpdated
{
    use SerializesModels;

    public Meeting $meeting;

    /**
     * Create a new event instance.
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     */
    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
    }
}
