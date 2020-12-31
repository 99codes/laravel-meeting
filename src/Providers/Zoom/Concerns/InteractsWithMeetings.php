<?php

namespace Nncodes\Meeting\Providers\Zoom\Concerns;

use Nncodes\Meeting\Contracts\Participant;
use Nncodes\Meeting\Events\MeetingCanceled;
use Nncodes\Meeting\Events\MeetingScheduled;
use Nncodes\Meeting\Events\MeetingUpdated;
use Nncodes\Meeting\Events\ParticipantAdded;
use Nncodes\Meeting\Events\ParticipationCanceled;
use Nncodes\Meeting\Exceptions\NoZoomRoomAvailable;
use Nncodes\Meeting\MeetingAdder;
use Nncodes\Meeting\Models\Meeting;
use Nncodes\Meeting\Models\MeetingRoom;
use Nncodes\Meeting\Models\Participant as ParticipantPivot;

trait InteractsWithMeetings
{
    use InteractsWithZoom;
    use ProvidesSettings;

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\MeetingAdder $meeting
     * @throws  \Nncodes\Meeting\Exceptions\NoZoomRoomAvailable
     * @return void
     */
    public function scheduling(MeetingAdder $meeting): void
    {
        if ($this->shareRooms()) {
            $endTime = (clone $meeting->startTime)->addMinutes($meeting->duration);
            if (! $host = MeetingRoom::findAvailable($meeting->startTime, $endTime)) {
                throw NoZoomRoomAvailable::create($meeting);
            }
            $meeting->hostedBy($host);
        }

        $zoomMeeting = $this->createZoomMeeting(
            $meeting->host->uuid,
            $meeting->topic,
            $meeting->startTime,
            $meeting->duration
        );

        $meeting->withMetaAttributes([
            'zoom_id' => $zoomMeeting->id,
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
        event(new MeetingScheduled($meeting));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function updating(Meeting $meeting): void
    {
        if ($meeting->isDirty()) {
            if ($meeting->isDirty('start_time')) {
                if ($this->shareRooms() && $meeting->host->isBusyBetween($meeting->start_time, $meeting->end_time, $meeting)) {
                    //Search for another host if the current is not available for the new start_time and duration
                    if (! $host = MeetingRoom::findAvailable($meeting->start_time, $meeting->end_time)) {
                        throw NoZoomRoomAvailable::createFromModel($meeting);
                    }
                    $meeting->updateHost($host);
                }
            }

            //If the host was changed, create a new zoom meeting and delete the previous one.
            if ($meeting->isDirty('host_id')) {
                $originalZoomMeetingId = $meeting->getMetaValue('zoom_id');

                //Create a new zoom meeting hosted by the new user (room)
                $zoomMeeting = $this->createZoomMeeting(
                    $meeting->host->uuid,
                    $meeting->topic,
                    $meeting->start_time,
                    $meeting->duration
                );
                
                //Update the zoom id referente and register the participants in the new zoom meeting
                $meeting->setMeta('zoom_id')->asInteger($zoomMeeting->id);

                $meeting->participantsPivot->each(function ($participant) use ($meeting) {
                    $meeting->cancelParticipation($participant->participant);
                    $meeting->addParticipant($participant->participant);
                });

                //Delete the original zoom meeting
                $this->api->deleteMeeting($originalZoomMeetingId);
            } else {

                //Update the zoom meeting without changing user (room)
                $this->updateZoomMeeting(
                    $meeting->meta->zoom_id,
                    $meeting->topic,
                    $meeting->start_time,
                    $meeting->duration
                );
            }
        }
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function updated(Meeting $meeting): void
    {
        event(new MeetingUpdated($meeting));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function starting(Meeting $meeting): void
    {
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function started(Meeting $meeting): void
    {
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function ending(Meeting $meeting): void
    {
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function ended(Meeting $meeting): void
    {
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function canceling(Meeting $meeting): void
    {
        $this->api->deleteMeeting($meeting->meta->zoom_id);
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return void
     */
    public function canceled(Meeting $meeting): void
    {
        event(new MeetingCanceled($meeting));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @param string $uuid
     * @return void
     */
    public function participantAdding(Participant $participant, Meeting $meeting, string $uuid): void
    {
        $registrant = $this->api->addMeetingParticipant($meeting->meta->zoom_id, [
            'email' => $participant->getParticipantEmailAddress(),
            'first_name' => $participant->getParticipantFirstName(),
            'last_name' => $participant->getParticipantLastName(),
        ]);

        $meeting->setMeta($uuid)->asObject($registrant);
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participantAdded(ParticipantPivot $participant): void
    {
        if ($metaUuid = $participant->meeting->getMeta($participant->uuid)) {
            $participant->setMeta('registrantId')->asString($metaUuid->value->registrantId);
            $participant->setMeta('joinUrl')->asString($metaUuid->value->joinUrl);
            $participant->setMeta('email')->asString($participant->participant->getParticipantEmailAddress());
            
            $metaUuid->delete();
        }

        event(new ParticipantAdded($participant));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participationCanceling(ParticipantPivot $participant): void
    {
        $registrant = [
            'id' => $participant->meta->registrantId,
            'email' => $participant->meta->email,
        ];

        $this->api->updateMeetingParticipantStatus($participant->meeting->meta->zoom_id, [
            'action' => 'cancel',
            'registrants' => [$registrant],
        ]);

        $participant->clearMetas();
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participationCanceled(ParticipantPivot $participant): void
    {
        event(new ParticipationCanceled($participant));
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participantJoining(ParticipantPivot $participant): void
    {
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participantJoined(ParticipantPivot $participant): void
    {
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participantLeaving(ParticipantPivot $participant): void
    {
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Participant $participant
     * @return void
     */
    public function participantLeft(ParticipantPivot $participant): void
    {
    }
}
