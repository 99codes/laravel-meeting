<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Actions;

use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\CloudRecording;
use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Meeting;
use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\MeetingParticipant;
use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\PastMeeting;
use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

trait ManagesMeetings
{
    /**
     * Register a participant for a meeting.
     *
     * @param int $meetingId The meeting ID
     * @param array $data
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\MeetingParticipant
     */
    public function addMeetingParticipant(int $meetingId, array $data, array $query = []): MeetingParticipant
    {
        return new MeetingParticipant($this->post("meetings/{$meetingId}/registrants?".http_build_query($query), $data), $this);
    }

    /**
     * Delete a meeting
     *
     * @param int $meetingId The meeting ID
     * @param array $query
     * @return void
     */
    public function deleteMeeting(int $meetingId, array $query = []): void
    {
        $this->delete("meetings/{$meetingId}?".http_build_query($query));
    }

    /**
     * Delete all recording files of a meeting.
     *
     * @param int $meetingId The meeting ID
     * @param array $query
     * @return void
     */
    public function deleteMeetingRecordings(int $meetingId, array $query = []): void
    {
        $this->delete("meetings/{$meetingId}/recordings?".http_build_query($query));
    }

    /**
     * Get a instance of meeting
     *
     * @param int $meetingId The meeting ID
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Meeting
     */
    public function meeting(int $meetingId, array $query = []): Meeting
    {
        return new Meeting($this->get("meetings/{$meetingId}?".http_build_query($query)), $this);
    }

    /**
     * Get the list of users that have registered for a meeting.
     *
     * @param int $meetingId The meeting ID
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function meetingParticipants(int $meetingId, array $query = []): Repository
    {
        $request = fn ($query, $paginator) => $this->transformCollection(
            $this->get("meetings/{$meetingId}/registrants?".http_build_query($query)),
            [MeetingParticipant::class, 'registrants'],
            $paginator
        );

        return $request($query, $request);
    }

    /**
     * 	Get all the  from a meeting or a Webinar.
     *
     * @param int $meetingId The meeting ID
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\CloudRecording
     */
    public function meetingRecordings(int $meetingId): CloudRecording
    {
        return new CloudRecording($this->get("meetings/{$meetingId}/recordings"), $this);
    }

    /**
     * * Get details on a past meeting.
     *
     * @param int $meetingId The meeting ID
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\PastMeeting
     */
    public function pastMeeting(int $meetingId): PastMeeting
    {
        return new PastMeeting($this->get("past_meetings/{$meetingId}"), $this);
    }

    /**
     * Zoom allows users to recover recordings from trash for up to 30 days from the deletion date.
     * Use this API to recover all deleted  of a specific meeting.
     *
     * @param string $meetingUUID The meeting UUID.
     * @param array $data
     * @return void
     */
    public function recoverMeetingRecordings(string $meetingUUID, array $data): void
    {
        $this->put("meetings/{$meetingUUID}/recordings/status", $data);
    }

    /**
     * Update a meeting
     *
     * @param int $meetingId The meeting ID
     * @param array $data
     * @param array $query
     * @return void
     */
    public function updateMeeting(int $meetingId, array $data, array $query = []): void
    {
        $this->patch("meetings/{$meetingId}?".http_build_query($query), $data);
    }

    /**
     * Update a meeting registrant’s status by either approving, cancelling or denying a registrant from joining the meeting.
     *
     * @param int $meetingId The meeting ID
     * @param array $data
     * @param array $query
     * @return void
     */
    public function updateMeetingParticipantStatus(int $meetingId, array $data, array $query = []): void
    {
        $this->put("meetings/{$meetingId}/registrants/status?".http_build_query($query), $data);
    }

    /**
     * Update a meeting
     *
     * @param int $meetingId The meeting ID
     * @param array $data
     * @return void
     */
    public function updateMeetingStatus(int $meetingId, array $data): void
    {
        $this->put("meetings/{$meetingId}/status", $data);
    }
}
