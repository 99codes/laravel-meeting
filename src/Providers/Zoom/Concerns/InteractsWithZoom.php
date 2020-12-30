<?php

namespace Nncodes\Meeting\Providers\Zoom\Concerns;

use Carbon\Carbon;
use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Meeting;

trait InteractsWithZoom
{
    /**
     * Undocumented function
     *
     * @param string $userId
     * @param string $topic
     * @param \Carbon\Carbon $startTime
     * @param int $duration
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Meeting
     */
    public function createZoomMeeting(string $userId, string $topic, Carbon $startTime, int $duration): Meeting
    {
        return $this->api->createUserMeeting($userId, [
            'topic' => $topic,
            'type' => 2,
            'start_time' => $startTime->format('Y-m-d\TH:i:s'),
            'duration' => $duration,
            'timezone' => $startTime->format('e'),
            'settings' => $this->getZoomMeetingDefaultSettings(),
        ]);
    }

    /**
     * Undocumented function
     *
     * @param int $meetingId
     * @param string $topic
     * @param \Carbon\Carbon $startTime
     * @param int $duration
     * @return void
     */
    public function updateZoomMeeting(int $meetingId, string $topic, Carbon $startTime, int $duration): void
    {
        $this->api->updateMeeting($meetingId, [
            'topic' => $topic,
            'type' => 2,
            'start_time' => $startTime->format('Y-m-d\TH:i:s'),
            'duration' => $duration,
            'timezone' => $startTime->format('e'),
            'settings' => config('meeting.providers.zoom.meeting_settings', []),
        ]);
    }
}
