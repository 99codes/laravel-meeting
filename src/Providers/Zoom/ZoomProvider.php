<?php

namespace Nncodes\Meeting\Providers\Zoom;

use Nncodes\Meeting\Contracts\Participant;
use Nncodes\Meeting\Contracts\Provider;
use Nncodes\Meeting\Models\Meeting;

class ZoomProvider implements Provider
{
    use Concerns\InteractsWithMeetings;

    /**
     * @var Zoom
     */
    protected Sdk\Zoom $api;

    /**
     * Undocumented function
     *
     * @param Zoom $zoom
     */
    public function __construct(Sdk\Zoom $zoom)
    {
        $this->api = $zoom;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getFacadeAccessor(): string
    {
        return 'zoom';
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @return mixed
     */
    public function getPresenterAccess(Meeting $meeting)
    {
        if ($zoomMeetingId = $meeting->getMetaValue('zoom_id')) {
            return optional($this->api->meeting($zoomMeetingId))->startUrl;
        }
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Models\Meeting $meeting
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @return mixed
     */
    public function getParticipantAccess(Meeting $meeting, Participant $participant)
    {
        return optional($meeting->participant($participant))->meta->joinUrl;
    }
}
