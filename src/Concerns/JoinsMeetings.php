<?php

namespace Nncodes\Meeting\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nncodes\Meeting\Models\Meeting;

trait JoinsMeetings
{
    /**
     * Get the MorphToMany Relation with the Meeting Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function meetings(): MorphToMany
    {
        return $this->morphToMany(Meeting::class, 'participant', 'meeting_participants')
            ->withPivot(['uuid', 'started_at', 'ended_at'])
            ->withTimestamps()
            ->with('scheduler', 'presenter', 'host');
    }
}
