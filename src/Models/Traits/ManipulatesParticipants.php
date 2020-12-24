<?php

namespace Nncodes\Meeting\Models\Traits;

use Carbon\Carbon;
use Nncodes\Meeting\Contracts\Participant;
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
     * @return boolean
     */
    public function hasParticipant(Participant $participant): bool
    {
        $morphType = get_class($participant);

        return $this->participants($morphType)->where([
            'participant_id' => $participant->id,
            'participant_type' => $morphType
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
            'participant_type' => $morphType
        ])->first();

        return $participant ? $participant->pivot : null;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @throws \Nncodes\Meeting\Exceptions\ParticipantAlreadyAdded
     * @return \Ramsey\Uuid\Uuid|null
     */
    public function addParticipant(Participant $participant): ParticipantPivot
    {
        if ($this->hasParticipant($participant)) {
            throw \Nncodes\Meeting\Exceptions\ParticipantAlreadyAdded::create($participant, $this);
        }

        $this->instance->participantAdding($participant, $this);

        $this->participants(get_class($participant))->save($participant, [
            'uuid' => \Illuminate\Support\Str::uuid()
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
        if (!$this->hasParticipant($participant)) {
            throw \Nncodes\Meeting\Exceptions\ParticipantNotRegistered::create($participant, $this);
        }

        $this->instance->participantCanceling($participant, $this);

        $participantPivot = $this->participant($participant);

        $canceled = $participantPivot->cancel();

        $this->instance->participantCanceled($participantPivot);

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
        if (!$this->hasParticipant($participant)) {
            throw \Nncodes\Meeting\Exceptions\ParticipantNotRegistered::create($participant, $this);
        }

        $this->instance->participantJoining($participant, $this);

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
        if (!$this->hasParticipant($participant)) {
            throw \Nncodes\Meeting\Exceptions\ParticipantNotRegistered::create($participant, $this);
        }

        $this->instance->participantLeaving($participant, $this);

        $this->instance->participantLeft(
            $participantPivot = $this->participant($participant)->leave()
        );

        return $participantPivot;
    }
}
