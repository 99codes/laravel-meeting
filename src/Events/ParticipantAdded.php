<?php

namespace Nncodes\Meeting\Events;

use Illuminate\Queue\SerializesModels;
use Nncodes\Meeting\Models\Participant;

class ParticipantAdded
{
    use SerializesModels;

    public Participant $participant;

    /**
     * Create a new event instance.
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }
}
