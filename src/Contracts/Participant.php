<?php

namespace Nncodes\Meeting\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
     * Email Address of the participant
     *
     * @return string
     */
    public function getParticipantEmailAddress(): string;

    /**
     * First name of the participant
     *
     * @return string
     */
    public function getParticipantFirstName(): string;

    /**
     * Last name of the participant
     *
     * @return string
     */
    public function getParticipantLastName(): string;

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

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailableBetween(Builder $query, Carbon $start, Carbon $end, ?Meeting $except = null): Builder;

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBusyBetween(Builder $query, Carbon $start, Carbon $end, ?Meeting $except = null): Builder;

    /**
     * Undocumented function
    *
    * @param \Carbon\Carbon $start
    * @param \Carbon\Carbon $end
    * @param \Nncodes\Meeting\Models\Meeting|null $except
    * @return bool
    */
    public function isAvailableBetween(Carbon $start, Carbon $end, ?Meeting $except = null): bool;

    /**
     * Undocumented function
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return bool
     */
    public function isBusyBetween(Carbon $start, Carbon $end, ?Meeting $except = null): bool;
}
