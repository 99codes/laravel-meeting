<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Resources;

use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

/**
 * The recording meeting object.
 */
class CloudRecording extends Resource
{
    /**
     * Unique Meeting Identifier. Each instance of the meeting will have its own UUID.
     * @var string
     */
    public string $uuid;

    /**
     * Meeting ID - also known as the meeting number.
     * @var string
     */
    public string $id;

    /**
     * Unique Identifier of the user account.
     * @var string
     */
    public string $accountId;

    /**
     * ID of the user set as host of meeting.
     * @var string
     */
    public string $hostId;

    /**
     * Meeting topic.
     * @var string
     */
    public string $topic;

    /**
     * The time at which the meeting started.
     * @var string
     */
    public string $startTime;

    /**
     * Meeting duration.
     * @var int
     */
    public int $duration;

    /**
     * Total size of the recording.
     * @var string
     */
    public string $totalSize;

    /**
     * Type of the meeting that was recorded.
     *
     * Meeting Types:`1` - Instant meeting.`2` - Scheduled meeting.`3` - Recurring meeting with no fixed time.`8` - Recurring meeting with fixed time.
     * @var string
     */
    public string $type;

    /**
     * Number of recording files returned in the response of this API call.
     * @var string
     */
    public string $recordingCount;

    /**
     * List of recording file.
     * @var \Nncodes\Meeting\Providers\Zoom\Support\Repository
     */
    public Repository $recordingFiles;

    /**
     * @var array
     */
    protected array $casts = [
        'recording_files' => RecordingFile::class,
    ];
}
