<?php

namespace Nncodes\Meeting\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nncodes\Meeting\Models\Meeting;
use Nncodes\Meeting\Models\Participant as ParticipantPivot;

interface Participant
{
    /**
     * Get the MorphToMany Relation with the Meeting Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function meetings(): MorphToMany;

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
    * @return \Nncodes\Meeting\Models\Participant
     */
    public function bookMeeting(Meeting $meeting): ParticipantPivot;

    /**
    * Undocumented function
    *
    * @param \Nncodes\Meeting\Models\Meeting $meeting
    * @return bool
    */
    public function cancelMeetingParticipation(Meeting $meeting): bool;

    /**
    * Undocumented function
    *
    * @param \Nncodes\Meeting\Models\Meeting $meeting
    * @return \Nncodes\Meeting\Models\Participant
    */
    public function joinMeeting(Meeting $meeting): ParticipantPivot;

    /**
    * Undocumented function
    *
    * @param \Nncodes\Meeting\Models\Meeting $meeting
    * @return \Nncodes\Meeting\Models\Participant
    */
    public function leaveMeeting(Meeting $meeting): ParticipantPivot;
}
