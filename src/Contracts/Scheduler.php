<?php

namespace Nncodes\Meeting\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nncodes\Meeting\MeetingAdder;

interface Scheduler
{
    /**
     * Get the MorphMany Relation with the Meeting Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function meetings(): MorphMany;

    /**
    * Undocumented function
    *
    * @param string|null $provider
    * @return \Nncodes\Meeting\MeetingAdder
    */
    public function scheduleMeeting(?string $provider = null): MeetingAdder;
}
