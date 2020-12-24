<?php

namespace Nncodes\Meeting\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nncodes\Meeting\MeetingAdder;
use Nncodes\Meeting\Models\Meeting;

/**
 * Provides default implementation of Scheduler contract.
 */
trait SchedulesMeetings
{
    /**
     * Get the MorphMany Relation with the Meeting Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function meetings(): MorphMany
    {
        return $this->morphMany(Meeting::class, 'scheduler')->with('presenter', 'host');
    }

    /**
     * Undocumented function
     *
     * @param string|null $provider
     * @return \Nncodes\Meeting\MeetingAdder
     */
    public function scheduleMeeting(?string $provider = null): MeetingAdder
    {
        return app(MeetingAdder::class)->withProvider($provider)->scheduledBy($this);
    }
}
