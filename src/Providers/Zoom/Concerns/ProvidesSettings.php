<?php

namespace Nncodes\Meeting\Providers\Zoom\Concerns;

trait ProvidesSettings
{
    /**
     * Undocumented function
     *
     * @return bool
     */
    public function shareRooms(): bool
    {
        return (bool) config('meeting.providers.zoom.share_rooms', false);
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getZoomMeetingDefaultSettings(): array
    {
        return config('meeting.providers.zoom.meeting_settings', []);
    }
}
