<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Resources;

/**
 * The recording file object.
 */
class RecordingFile extends Resource
{
    /**
     * The recording file ID. Included in the response of general query.
     * @var string
     */
    public string $id;

    /**
     * The meeting ID.
     * @var string
     */
    public string $meetingId;

    /**
     * The recording start time.
     * @var string
     */
    public string $recordingStart;

    /**
     * The recording end time. Response in general query.
     * @var string
     */
    public string $recordingEnd;

    /**
     * The recording file type. The value of this field could be one of the following:
     * `MP4`: Video file of the recording.`M4A` Audio-only file of the recording.`TIMELINE`: Timestamp file of the recording in JSON file format. To get a timeline file, the "Add a timestamp to the recording" setting must be enabled in the [recording settings](https://support.zoom.us/hc/en-us/articles/203741855-Cloud-recording#h_3f14c3a4-d16b-4a3c-bbe5-ef7d24500048). The time will display in the host's timezone, set on their Zoom profile.
     *  `TRANSCRIPT`: Transcription file of the recording in VTT format. `CHAT`: A TXT file containing in-meeting chat messages that were sent during the meeting.`CC`: File containing closed captions of the recording in VTT file format.
     * A recording file object with file type of either `CC` or `TIMELINE` **does not have** the following properties:
     * 	`id`, `status`, `file_size`, `recording_type`, and `play_url`.
     * @var string
     */
    public string $fileType;

    /**
     * The recording file size.
     * @var int
     */
    public int $fileSize;

    /**
     * The URL using which a recording file can be played.
     * @var string
     */
    public string $playUrl;

    /**
     * The URL using which the recording file can be downloaded. **To access a private or password protected cloud recording of a user in your account, you can use a [Zoom JWT App Type](https://marketplace.zoom.us/docs/guides/getting-started/app-types/create-jwt-app). Use the generated JWT token as the value of the `access_token` query parameter and include this query parameter at the end of the URL as shown in the example.**
     *
     * Example: `https://api.zoom.us/recording/download/{{ Download Path }}?access_token={{ JWT Token }}`
     *
     * **Similarly, if the user has installed your OAuth app that contains recording scope(s), you can also use the user's [OAuth access token](https://marketplace.zoom.us/docs/guides/auth/oauth) to download the Cloud Recording.**
     *
     * Example: `https://api.zoom.us/recording/download/{{ Download Path }}?access_token={{ OAuth Access Token }}`
     *
     *
     * @var string
     */
    public string $downloadUrl;

    /**
     * The recording status.
     * @var string
     */
    public string $status;

    /**
     * The time at which recording was deleted. Returned in the response only for trash query.
     * @var string
     */
    public string $deletedTime;

    /**
     * The recording type. The value of this field can be one of the following:`shared_screen_with_speaker_view(CC)``shared_screen_with_speaker_view``shared_screen_with_gallery_view``speaker_view``gallery_view``shared_screen``audio_only``audio_transcript``chat_file``active_speaker`
     * @var string
     */
    public string $recordingType;

    /**
     * Delete a sprecific recording file from a meeting.
     *
     * @param array $query
     * @return void
     */
    public function delete(array $query = []): void
    {
        $this->zoom->deleteMeetingRecordingFile($this->meetingId, $this->id, $query);
    }

    /**
     * Zoom allows users to recover recordings from trash for up to 30 days from the deletion date.
     * Use this API to recover a single recording file from the meeting.
     *
     * @param array $query
     * @return void
     */
    public function recover(array $query = []): void
    {
        $this->zoom->recoverMeetingRecordingFile($this->meetingId, $this->id, $query);
    }
}
