<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Resources;

use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

/**
 * Meeting object.
 */
class Meeting extends Resource
{
    /**
     * Unique meeting ID. Each meeting instance will generate its own Meeting UUID (i.e., after a meeting ends, a new UUID will be generated for the next instance of the meeting). You can retrieve a list of UUIDs from past meeting instances using [this API](https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/pastmeetings) . Please double encode your UUID when using it for API calls if the UUID begins with a '/'or contains '//' in it.
     *
     * @var string
     */
    public string $uuid;

    /**
     * [Meeting ID](https://support.zoom.us/hc/en-us/articles/201362373-What-is-a-Meeting-ID-): Unique identifier of the meeting in "**long**" format(represented as int64 data type in JSON), also known as the meeting number.
     * @var int
     */
    public int $id;

    /**
     * ID of the user who is set as host of meeting.
     * @var string
     */
    public string $hostId;

    /**
     * Unique identifier of the scheduler who scheduled this meeting on behalf of the host. This field is only returned if you used "schedule_for" option in the [Create a Meeting API request](https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingcreate).
     * @var string
     */
    public string $assistantId;

    /**
     * Email address of the meeting host.
     * @var string
     */
    public string $hostEmail;

    /**
     * Meeting topic.
     * @var string
     */
    public string $topic;

    /**
     * Meeting Types:`1` - Instant meeting.`2` - Scheduled meeting.`3` - Recurring meeting with no fixed time.`4` - PMI Meeting
     * `8` - Recurring meeting with a fixed time.
     * @var int
     */
    public int $type = 2;

    /**
     * Meeting status
     * @var string
     */
    public string $status;

    /**
     * Meeting start time in GMT/UTC. Start time will not be returned if the meeting is an **instant** meeting.
     *
     * @var string
     */
    public string $startTime;

    /**
     * Meeting duration.
     * @var int
     */
    public int $duration;

    /**
     * Timezone to format the meeting start time on the .
     * @var string
     */
    public string $timezone;

    /**
     * Time of creation.
     * @var string
     */
    public string $createdAt;

    /**
     * Agenda.
     * @var string
     */
    public string $agenda;

    /**
     * The start_url of a Meeting is a URL using which a host or an alternative host can start the Meeting.
     * The expiration time for the start_url field listed in the response of [Create a Meeting API](https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingcreate) is two hours for all regular users.
     * For users created using the custCreate option via the [Create Users](https://marketplace.zoom.us/docs/api-reference/zoom-api/users/usercreate) API, the expiration time of the start_url field is 90 days.
     * For security reasons, to retrieve the updated value for the start_url field programmatically (after the expiry time), you must call the [Retrieve a Meeting API](https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meeting) and refer to the value of the start_url field in the response.This URL should only be used by the host of the meeting and **should not be shared with anyone other than the host** of the meeting as anyone with this URL will be able to login to the Zoom Client as the host of the meeting.
     * @var string
     */
    public string $startUrl;

    /**
     * URL for participants to join the meeting. This URL should only be shared with users that you would like to invite for the meeting.
     * @var string
     */
    public string $joinUrl;

    /**
     * Meeting passcode.
     * @var string
     */
    public string $password;

    /**
     * H.323/SIP room system passcode.
     * @var string
     */
    public string $h323Password;

    /**
     * Encrypted passcode for third party endpoints (H323/SIP).
     * @var string
     */
    public string $encryptedPassword;

    /**
     * Personal Meeting Id. Only used for scheduled meetings and recurring meetings with no fixed time.
     * @var int
     */
    public int $pmi;

    /**
     * Tracking fields
     * @var array
     */
    public array $trackingFields;

    /**
     * Array of occurrence objects.
     * @var array
     */
    public array $occurrences;

    /**
     * Meeting settings.
     * @var array
     */
    public array $settings;

    /**
     * Recurrence object. Use this object only for a meeting with type `8` i.e., a recurring meeting with fixed time.
     * @var array
     */
    public array $recurrence;

    /**
     * Register a participant for a meeting.
     *
     * @param array $data
     * @param array $query
     * @return MeetingParticipant
     */
    public function addParticipant(array $data, array $query = []): MeetingParticipant
    {
        return $this->zoom->addMeetingParticipant($this->id, $data, $query);
    }

    /**
     * Delete a meeting
     *
     * @param array $query
     * @return void
     */
    public function delete(array $query = []): void
    {
        $this->zoom->deleteMeeting($this->id, $query);
    }

    /**
     * Delete all recording files of a meeting.
     *
     * @param array $query
     * @return void
     */
    public function deleteRecordings(array $query = []): void
    {
        $this->zoom->deleteMeetingRecordings($this->id, $query);
    }

    /**
     * Get the list of users that have registered for a meeting.
     *
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Support\Repository
     */
    public function participants(array $query = []): Repository
    {
        return $this->zoom->meetingParticipants($this->id, $query);
    }

    /**
     * Get all the  from a meeting or a Webinar.
     *
     * @return CloudRecording
     */
    public function recordings(): CloudRecording
    {
        return $this->zoom->meetingRecordings($this->id);
    }

    /**
     * Get details on a past meeting.
     *
     * @return PastMeeting
     */
    public function past(): PastMeeting
    {
        return $this->zoom->pastMeeting($this->id);
    }

    /**
     * Zoom allows users to recover recordings from trash for up to 30 days from the deletion date.
     * Use this API to recover all deleted  of a specific meeting.
     *
     * @param array $data
     * @return void
     */
    public function recoverRecordings(array $data): void
    {
        $this->zoom->recoverMeetingRecordings($this->uuid, $data);
    }

    /**
     * Update a meeting
     *
     * @param array $data
     * @param array $query
     * @return void
     */
    public function update(array $data, array $query = []): void
    {
        $this->zoom->updateMeeting($this->id, $data, $query);
    }

    /**
     * Update a meeting registrant’s status by either approving, cancelling or denying a registrant from joining the meeting.
     *
     * @param array $data
     * @param array $query
     * @return void
     */
    public function updateParticipantStatus(array $data, array $query = []): void
    {
        $this->zoom->updateMeetingParticipantStatus($this->id, $data, $query);
    }

    /**
     * Update a meeting
     *
     * @param array $data
     * @return void
     */
    public function updateStatus(array $data): void
    {
        $this->zoom->updateMeetingStatus($this->id, $data);
    }
}
