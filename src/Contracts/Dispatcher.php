<?php

namespace Nncodes\Meeting\Contracts;

use Nncodes\Meeting\Models\Meeting;
use Nncodes\Meeting\Contracts\Participant;
use Nncodes\Meeting\Models\Participant as ParticipantModel;

interface Dispatcher
{
     /**
     * Schedule a meeting by saving the model instance.
     * Call the scheduling and scheduled handler methods just before and after saving
     *
     * @param Resource $resource
     * @return \Nncodes\Meeting\Models\Meeting
     */
    public function schedule(Resource $resource): Meeting;

    /**
     *  Handle the meeting model instace before save
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function scheduling(Meeting $meeting): void;

    /**
     * Handle the meeting model instance after save
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function scheduled(Meeting $meeting): void;

    /**
    * Add a participant to a meeting by associating the participant to the meeting
    * Call the joining and joined handler methods just before and after associating
    *
    * @param \Nncodes\Meeting\Models\Meeting $meeting
    * @param \Nncodes\Meeting\Contracts\Participant $participant
    * @return \Nncodes\Meeting\Contracts\Participant
    */
    public function join(Meeting $meeting, Participant $participant): Participant;

   /**
    * Handle the participant model instance before associate
    *
    * @param \Nncodes\Meeting\Contracts\Participant $participant
    * @return void
    */
    public function joining(Participant $participant): void;

    /**
     * Handle the participant model instance after associate
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function joined(ParticipantModel $participant): void;
   
}
