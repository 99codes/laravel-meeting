<?php

namespace Nncodes\Meeting\Models\Traits;

use Carbon\Carbon;
use Nncodes\Meeting\Contracts\Host;
use Nncodes\Meeting\Contracts\Presenter;
use Nncodes\Meeting\Contracts\Scheduler;
use Nncodes\Meeting\MeetingAdder;

/**
 * Provides manipulation methods for meeting model
 */
trait ManipulatesMeeting
{
    /**
    * Undocumented function
    *
    * @param string|null $provider
    * @return \Nncodes\Meeting\MeetingAdder
    */
    public static function schedule(?string $provider = null): MeetingAdder
    {
        return app(MeetingAdder::class)->withProvider($provider);
    }

    /**
     * Undocumented function
     *
     * @param string $topic
     * @return self
     */
    public function updateTopic(string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param \Carbon\Carbon $startTime
     * @return self
     */
    public function updateStartTime(Carbon $startTime): self
    {
        $now = now();

        if ($startTime->lessThanOrEqualTo($now)) {
            //@todo exception startTime cannot be less than now
        }

        $this->start_time = $startTime;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param int $duration
     * @return self
     */
    public function updateDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Host $host
     * @return self
     */
    public function updateHost(Host $host): self
    {
        $this->host()->associate($host);
        $this->save();

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Presenter $presenter
     * @return self
     */
    public function updatePresenter(Presenter $presenter): self
    {
        $this->presenter()->associate($presenter);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Scheduler $scheduler
     * @return self
     */
    public function updateScheduler(Scheduler $scheduler): self
    {
        $this->scheduler()->associate($scheduler);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return self
     */
    public function start(): self
    {
        $this->instance->starting($this);

        $startedAt = $this->started_at ?? now();
        $this->fill(['started_at' => $startedAt])->save();

        $this->instance->started($this);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return self
     */
    public function end(): self
    {
        $this->instance->ending($this);

        $endedAt = $this->ended_at ?? now();
        $this->fill(['ended_at' => $endedAt])->save();

        $this->instance->ended($this);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return bool
     */
    public function cancel(): bool
    {
        $this->instance->canceling($this);

        $deleted = $this->delete();

        $this->instance->canceled($this);

        return $deleted;
    }

    /**
     * Undocumented function
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if ($this->exists) {
            $this->instance->updating($this);
        }

        $saved = parent::save($options);

        if ($this->exists) {
            $this->instance->updated($this);
        }

        return $saved;
    }
}
