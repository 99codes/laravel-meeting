<?php

namespace Nncodes\Meeting\Models\Traits;

use Carbon\Carbon;
use Nncodes\Meeting\Contracts\Provider;

/**
 * Provides access methods to the meeting instance
 */
trait ProvidesMeetingAccessors
{
    /**
     * Undocumented function
     *
     * @return \Nncodes\Meeting\Contracts\Provider
     */
    public function getInstanceAttribute(): Provider
    {
        if (! config('meeting.providers.' . $this->provider)) {
            throw \Nncodes\Meeting\Exceptions\InvalidProvider::create($this->provider);
        }

        return resolve("laravel-meeting:{$this->provider}");
    }

    /**
     * Undocumented function
     *
     * @return \Carbon\Carbon
     */
    public function getEndTimeAttribute(): Carbon
    {
        $startTime = clone $this->start_time;

        return $startTime->addMinutes($this->duration);
    }

    /**
     * Undocumented function
     *
     * @return int|null
     */
    public function getElapsedTimeAttribute(): ?int
    {
        if ($this->started_at) {
            $endedAt = $this->ended_at ?: now();

            return $this->started_at->diffInMinutes($endedAt);
        }

        return 0;
    }
}
