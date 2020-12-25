<?php

namespace Nncodes\Meeting\Providers\Zoom\Actions;

use Nncodes\Meeting\Providers\Zoom\Resources\MeetingParticipant;
use Nncodes\Meeting\Providers\Zoom\Support\Repository;

trait ManagesPastMeetings
{
	/**
	 * Get a list of ended meeting instances
	 *
	 * @param integer $meetingId The meeting ID
	 * @return array
	 */
	public function pastMeetingInstances(int $meetingId): array
	{
		return $this->get("past_meetings/{$meetingId}/instances");
	}

	/**
	 * Retrieve information on participants from a past meeting.
	 *
	 * @param integer $meetingId The meeting I
	 * @param array $query
	 * @return \Nncodes\Meeting\Providers\Zoom\Support\Repository
	 */
	public function pastMeetingParticipants(int $meetingId, array $query = []): Repository
	{
		$request = fn($query, $paginator) => $this->transformCollection(
			$this->get("past_meetings/{$meetingId}/participants?".http_build_query($query)),
			[MeetingParticipant::class, 'participants'],
			$paginator
		);

		return $request($query, $request);
	}
}
