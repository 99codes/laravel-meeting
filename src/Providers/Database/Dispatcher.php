<?php

namespace Nncodes\Meeting\Providers\Database;

use Nncodes\Meeting\Contracts\Dispatcher as Contract;
use Nncodes\Meeting\Contracts\Participant;
use Nncodes\Meeting\Contracts\Resource;
use Nncodes\Meeting\Models\Meeting;
use Nncodes\Meeting\Models\Participant as ParticipantModel;

class Dispatcher implements Contract
{
    /**
     * Schedule and the meeting by saving the model instance.
     * Call the scheduling and scheduled handler methods just before and after saving
     *
     * @param Resource $resource
     * @return \Nncodes\Meeting\Models\Meeting
     */
    public function schedule(Resource $resource): Meeting
    {
        $meeting = new Meeting([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'topic' => $resource->topic(),
            'start_time' => $resource->startTime(),
            'duration' => $resource->duration(),
            'provider' => $resource->provider(),
        ]);

        $meeting->scheduler()->associate($resource->scheduler());
        $meeting->presenter()->associate($resource->presenter());
        $meeting->host()->associate($resource->host());

        $this->scheduling($meeting);
        
        $meeting->save();

        $this->scheduled($meeting);

        return $meeting;
    }

    /**
     * Handle the meeting model instace before save
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function scheduling(Meeting $meeting): void
    {
    }

    /**
     * Handle the meeting model instace after save
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function scheduled(Meeting $meeting): void
    {
    }

    /**
    * Add a participant to a meeting by associating the participant to the meeting
    * Call the joining and joined handler methods just before and after associating
    *
    * @param \Nncodes\Meeting\Models\Meeting $meeting
    * @param \Nncodes\Meeting\Contracts\Participant $participant
    * @return \Nncodes\Meeting\Contracts\Participant
    */
    public function join(Meeting $meeting, Participant $participant): Participant
    {
        $morphType = get_class($participant);
        $uuid = \Illuminate\Support\Str::uuid();

        $this->joining($participant);

        $meeting->participants($morphType)
                ->attach($participant, [
                    'uuid' => $uuid,
                ]);

        $participantPivot = $meeting->participants($morphType)
                ->wherePivot('uuid', $uuid)
                ->withPivot(['uuid'])
                ->withTimestamps()
                ->first();

        $this->joined($participantPivot->pivot);

        return $participantPivot;
    }

    /**
    * Handle the participant model instance before associate
    *
    * @param \Nncodes\Meeting\Contracts\Participant $participant
    * @return void
    */
    public function joining(Participant $participant): void
    {
    }

    /**
     * Handle the participant model instance after associate
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function joined(ParticipantModel $participant): void
    {
    }
}
