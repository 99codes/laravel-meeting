<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Actions;

use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\MeetingParticipant;
use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

trait ManagesPastMeetings
{
    /**
     * Get a list of ended meeting instances
     *
     * @param int $meetingId The meeting ID
     * @return array
     */
    public function pastMeetingInstances(int $meetingId): array
    {
        return $this->get("past_meetings/{$meetingId}/instances");
    }

    /**
     * Retrieve information on participants from a past meeting.
     *
     * @param int $meetingId The meeting I
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function pastMeetingParticipants(int $meetingId, array $query = []): Repository
    {
        $request = fn ($query, $paginator) => $this->transformCollection(
            $this->get("past_meetings/{$meetingId}/participants?".http_build_query($query)),
            [MeetingParticipant::class, 'participants'],
            $paginator
        );

        return $request($query, $request);
    }
}
