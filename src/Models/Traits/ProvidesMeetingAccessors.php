<?php

namespace Nncodes\Meeting\Models\Traits;

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
     * @return int|null
     */
    public function getRealDurationAttribute(): ?int
    {
        if ($this->started_at && $this->ended_at) {
            return $this->started_at->diffInMinutes($this->ended_at);
        }
    }
}
