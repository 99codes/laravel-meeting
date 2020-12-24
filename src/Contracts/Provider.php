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

    public function participantAdding(Participant $participant, Meeting $meeting): void;

    public function participantAdded(ParticipantPivot $participant): void;

    public function participantCanceling(Participant $participant, Meeting $meeting): void;

    public function participantCanceled(ParticipantPivot $participant): void;

    public function participantJoining(Participant $participant, Meeting $meeting): void;

    public function participantJoined(ParticipantPivot $participant): void;

    public function participantLeaving(Participant $participant, Meeting $meeting): void;

    public function participantLeft(ParticipantPivot $participant): void;
}
