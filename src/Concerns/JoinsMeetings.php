<?php

namespace Nncodes\Meeting\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nncodes\Meeting\Models\Meeting;
use Nncodes\Meeting\Models\Participant;
use Nncodes\Meeting\Models\Traits\VerifiesAvailability;

/**
 * Provides default implementation of Participant contract.
 */
trait JoinsMeetings
{
    use VerifiesAvailability;
    
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

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return \Nncodes\Meeting\Models\Participant
     */
    public function bookMeeting(Meeting $meeting): Participant
    {
        return $meeting->addParticipant($this);
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return bool
     */
    public function cancelMeetingParticipation(Meeting $meeting): bool
    {
        return $meeting->cancelParticipation($this);
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return \Nncodes\Meeting\Models\Participant
     */
    public function joinMeeting(Meeting $meeting): Participant
    {
        return $meeting->joinParticipant($this);
    }

    /**
    * Undocumented function
    *
    * @param \Nncodes\Meeting\Models\Meeting $meeting
    * @return \Nncodes\Meeting\Models\Participant
    */
    public function leaveMeeting(Meeting $meeting): Participant
    {
        return $meeting->leaveParticipant($this);
    }
}
