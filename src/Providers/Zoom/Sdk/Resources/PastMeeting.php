<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Resources;

use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

/**
 * PastMeeting
 */
class PastMeeting extends Resource
{
    /**
     * Meeting UUID.
     * @var string
     */
    public string $uuid;

    /**
     * Meeting ID
     * @var int
     */
    public int $id;

    /**
     * Host ID.
     * @var string
     */
    public string $hostId;

    /**
     * Meeting type.
     * @var int
     */
    public int $type;

    /**
     * Meeting topic.
     * @var string
     */
    public string $topic;

    /**
     * User display name.
     * @var string
     */
    public string $userName;

    /**
     * User email.
     * @var string
     */
    public string $userEmail;

    /**
     * Meeting start time (GMT).
     * @var string
     */
    public string $startTime;

    /**
     * Meeting end time (GMT).
     * @var string
     */
    public string $endTime;

    /**
     * Meeting duration.
     * @var int
     */
    public int $duration;

    /**
     * Sum of meeting minutes from all participants in the meeting.
     * @var int
     */
    public int $totalMinutes;

    /**
     * Number of meeting participants.
     * @var int
     */
    public int $participantsCount;

    /**
     * Get a list of ended meeting instances
     *
     * @return array
     */
    public function instances(): array
    {
        return $this->zoom->pastMeetingInstances($this->id);
    }

    /**
     * Retrieve information on participants from a past meeting.
     *
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Support\Repository
     */
    public function participants(array $query = []): Repository
    {
        return $this->zoom->pastMeetingParticipants($this->id, $query);
    }
}
