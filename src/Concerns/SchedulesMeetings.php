<?php

namespace Nncodes\Meeting\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nncodes\Meeting\Models\Meeting as MeetingModel;

trait SchedulesMeetings
{
    /**
     * Get the MorphMany Relation with the Meeting Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function meetings(): MorphMany
    {
        return $this->morphMany(MeetingModel::class, 'scheduler')->with('presenter', 'host');
    }
}