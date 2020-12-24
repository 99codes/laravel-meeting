<?php

namespace Nncodes\Meeting\Providers;

use Nncodes\Meeting\Contracts\Participant;
use Nncodes\Meeting\Contracts\Provider;
use Nncodes\Meeting\MeetingAdder;
use Nncodes\Meeting\Models\Meeting;
use Nncodes\Meeting\Models\Participant as ParticipantPivot;

class Starter implements Provider
{
    /**
     * Undocumented function
     *
     * @return string
     */
    public function getFacadeAccessor(): string
    {
        return 'starter';
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\MeetingAdder $meeting
     * @return void
     */
    public function scheduling(MeetingAdder $meeting): void
    {
        $meeting->withMetaAttributes([
            __METHOD__ => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function scheduled(Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function updating(Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function updated(Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function starting(Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function started(Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function ending(Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function ended(Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function canceling(Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function canceled(Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function participantAdding(Participant $participant, Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participantAdded(ParticipantPivot $participant): void
    {
        $participant->meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function participantCanceling(Participant $participant, Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participantCanceled(ParticipantPivot $participant): void
    {
        $participant->meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function participantJoining(Participant $participant, Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participantJoined(ParticipantPivot $participant): void
    {
        $participant->meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function participantLeaving(Participant $participant, Meeting $meeting): void
    {
        $meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participantLeft(ParticipantPivot $participant): void
    {
        $participant->meeting->setMetaAttribute(__METHOD__, now()->format('Y-m-d H:i:s'));
    }
}
