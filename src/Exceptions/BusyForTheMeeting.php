<?php

namespace Nncodes\Meeting\Exceptions;

use Nncodes\Meeting\Contracts\Participant;
use Nncodes\Meeting\MeetingAdder;
use Nncodes\Meeting\Models\Meeting;

class BusyForTheMeeting extends \Exception
{

    /**
     * @var \Nncodes\Meeting\MeetingAdder
     */
    protected MeetingAdder $meeting;

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\MeetingAdder $meeting
     * @param string $relation
     * @return self
     */
    public static function create(MeetingAdder $meeting, string $relation): self
    {
        return new static(
            'There `%s` is busy between `%s` and `%s` to be %s in the meeting with topic `%s`',
            $meeting,
            $relation
        );
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @return self
     */
    public static function createForParticipant(Meeting $meeting, Participant $participant): self
    {
        $meetingAdder = (new MeetingAdder)
            ->scheduledBy($meeting->scheduler)
            ->presentedBy($meeting->presenter)
            ->hostedBy($meeting->host)
            ->withTopic($meeting->topic)
            ->startingAt($meeting->start_time)
            ->during($meeting->duration);

        $meetingAdder->participant = $participant;

        return static::create($meetingAdder, 'participant');
    }

    /**
     * Create a new instance of NoZoomRoomAvailable exception
     *
     * @param string $message
     * @param \Nncodes\Meeting\MeetingAdder $meeting
     * @param string $relation
     */
    public function __construct(string $message, MeetingAdder $meeting, string $relation)
    {
        $actor = get_class($meeting->{$relation}).':'.$meeting->{$relation}->id;

        $this->meeting = $meeting;
        $this->message = sprintf(
            $message,
            $actor,
            $meeting->startTime->format('Y-m-d H:i:se'),
            (clone $meeting->startTime)->addMinutes($meeting->duration)->format('Y-m-d H:i:se'),
            $relation,
            $meeting->topic
        );
    }

    /**
     * Get the meeting that regeneted the exception
     *
     * @return \Nncodes\Meeting\MeetingAdder
     */
    public function getMeeting(): MeetingAdder
    {
        return $this->meeting;
    }
}
