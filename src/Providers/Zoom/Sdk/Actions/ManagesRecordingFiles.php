<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Actions;

trait ManagesRecordingFiles
{
    /**
     * Delete a sprecific recording file from a meeting.
     *
     * @param string $meetingId To get Cloud Recordings of a meeting, provide the meeting ID or meeting UUID.
     * If the meeting ID is provided instead of UUID,the response will be for the latest meeting instance.
     * @param string $recordingId The recording ID.
     * @param array $query
     * @return void
     */
    public function deleteMeetingRecordingFile(string $meetingId, string $recordingId, array $query = []): void
    {
        $this->delete("meetings/{$meetingId}/recordings/{$recordingId}?".http_build_query($query));
    }

    /**
     * Zoom allows users to recover recordings from trash for up to 30 days from the deletion date.
     * Use this API to recover a single recording file from the meeting.
     *
     * @param string $meetingId To get Cloud Recordings of a meeting, provide the meeting ID or meeting UUID.
     * If the meeting ID is provided instead of UUID,the response will be for the latest meeting instance
     * @param string $recordingId The recording ID.
     * @param array $query
     * @return void
     */
    public function recoverMeetingRecordingFile(string $meetingId, string $recordingId, array $query = []): void
    {
        $this->put("meetings/{$meetingId}/recordings/{$recordingId}/status?".http_build_query($query));
    }
}
