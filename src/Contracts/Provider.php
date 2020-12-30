<?php

namespace Nncodes\Meeting\Contracts;

use Nncodes\Meeting\MeetingAdder;
use Nncodes\Meeting\Models\Meeting;
use Nncodes\Meeting\Models\Participant as ParticipantPivot;

interface Provider
{
    public function getFacadeAccessor(): string;

    public function scheduling(MeetingAdder $meeting): void;

    public function scheduled(Meeting $meeting): void;

    public function updating(Meeting $meeting): void;

    public function updated(Meeting $meeting): void;

    public function starting(Meeting $meeting): void;

    public function started(Meeting $meeting): void;

    public function ending(Meeting $meeting): void;
    
    public function ended(Meeting $meeting): void;

    public function canceling(Meeting $meeting): void;

    public function canceled(Meeting $meeting): void;

    public function participantAdding(Participant $participant, Meeting $meeting, string $uuid): void;

    public function participantAdded(ParticipantPivot $participant): void;

    public function participationCanceling(ParticipantPivot $participant): void;

    public function participationCanceled(ParticipantPivot $participant): void;

    public function participantJoining(ParticipantPivot $participant): void;

    public function participantJoined(ParticipantPivot $participant): void;

    public function participantLeaving(ParticipantPivot $participant): void;

    public function participantLeft(ParticipantPivot $participant): void;

    public function getPresenterAccess(Meeting $meeting);

    public function getParticipantAccess(Meeting $meeting, Participant $participant);
}
