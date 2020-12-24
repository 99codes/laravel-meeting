<?php

namespace Nncodes\Meeting\Exceptions;

use Nncodes\Meeting\Contracts\Participant;
use Nncodes\Meeting\Models\Meeting;

class ParticipantNotRegistered extends \Exception
{

    /**
     * @var \Nncodes\Meeting\Contracts\Participant
     */
    protected Participant $participant;

    /**
     * Provides a static method to create a new instance of ParticipantNotRegistered Exception
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return self
     */
    public static function create(Participant $participant, Meeting $meeting): self
    {
        return new static(
            'The provided participant `%s:%d` is not registered in `%s:%d`',
            $participant,
            $meeting
        );
    }

    /**
     * Create a new instance of ParticipantNotRegistered exception
     *
     * @param string $message
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     */
    public function __construct(string $message, Participant $participant, Meeting $meeting)
    {
        $this->message = sprintf(
            $message,
            get_class($participant),
            $participant->id,
            $meeting->getMorphClass(),
            $meeting->id
        );

        $this->code = $meeting->id;
        $this->participant = $participant;
    }

    /**
     * Get the meeting id
     *
     * @return int
     */
    public function getMeetingId(): int
    {
        return $this->code;
    }

    /**
     * Get the already registered participant
     *
     * @return \Nncodes\Meeting\Contracts\Participant
     */
    public function getParticipant(): Participant
    {
        return $this->participant;
    }
}
