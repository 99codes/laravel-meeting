<?php

namespace Nncodes\Meeting\Models\Traits;

use Nncodes\Meeting\Contracts\Participant;
use Nncodes\Meeting\Exceptions\BusyForTheMeeting;
use Nncodes\Meeting\Models\Participant as ParticipantPivot;

/**
 * Provides verification methods for a meeting model
 */
trait ManipulatesParticipants
{
    /**
     * Check if the meeting has a given participant
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @return bool
     */
    public function hasParticipant(Participant $participant): bool
    {
        $morphType = get_class($participant);

        return $this->participants($morphType)->where([
            'participant_id' => $participant->id,
            'participant_type' => $morphType,
        ])->exists();
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @return \Nncodes\Meeting\Models\Participant|null
     */
    public function participant(Participant $participant): ?ParticipantPivot
    {
        $morphType = get_class($participant);

        $participant = $this->participants($morphType)->where([
            'participant_id' => $participant->id,
            'participant_type' => $morphType,
        ])->first();

        return $participant ? $participant->pivot : null;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @return \Nncodes\Meeting\Models\Participant
     */
    public function addParticipant(Participant $participant): ParticipantPivot
    {
        if ($this->hasParticipant($participant)) {
            throw \Nncodes\Meeting\Exceptions\ParticipantAlreadyAdded::create($participant, $this);
        }

        if (! config('meeting.allow_concurrent_meetings.participant')
            && $participant->isBusyBetween($this->start_time, $this->end_time)
        ) {
            throw BusyForTheMeeting::createForParticipant($this, $participant);
        }
        
        $this->instance->participantAdding($participant, $this, $uuid = \Illuminate\Support\Str::uuid());

        $this->participants(get_class($participant))->save($participant, [
            'uuid' => $uuid,
        ]);

        $this->instance->participantAdded(
            $createdParticipant = $this->participant($participant)
        );

        return $createdParticipant;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @throws \Nncodes\Meeting\Exceptions\ParticipantNotRegistered
     * @return bool
     */
    public function cancelParticipation(Participant $participant): bool
    {
        if (! $participantPivot = $this->participant($participant)) {
            throw \Nncodes\Meeting\Exceptions\ParticipantNotRegistered::create($participant, $this);
        }

        $this->instance->participationCanceling($participantPivot);

        $canceled = $participantPivot->cancel();

        $this->instance->participationCanceled($participantPivot);

        return $canceled;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @throws \Nncodes\Meeting\Exceptions\ParticipantNotRegistered
     * @return \Carbon\Carbon
     */
    public function joinParticipant(Participant $participant): ParticipantPivot
    {
        if (! $participantPivot = $this->participant($participant)) {
            throw \Nncodes\Meeting\Exceptions\ParticipantNotRegistered::create($participant, $this);
        }

        $this->instance->participantJoining($participantPivot, $this);

        $this->instance->participantJoined(
            $participantPivot = $this->participant($participant)->join()
        );

        return $participantPivot;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @throws \Nncodes\Meeting\Exceptions\ParticipantNotRegistered
     * @return \Carbon\Carbon
     */
    public function leaveParticipant(Participant $participant): ParticipantPivot
    {
        if (! $participantPivot = $this->participant($participant)) {
            throw \Nncodes\Meeting\Exceptions\ParticipantNotRegistered::create($participant, $this);
        }

        $this->instance->participantLeaving($participantPivot, $this);

        $this->instance->participantLeft(
            $participantPivot = $this->participant($participant)->leave()
        );

        return $participantPivot;
    }
}
