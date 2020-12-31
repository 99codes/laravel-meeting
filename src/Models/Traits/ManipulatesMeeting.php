<?php

namespace Nncodes\Meeting\Models\Traits;

use Carbon\Carbon;
use Nncodes\Meeting\Contracts\Host;
use Nncodes\Meeting\Contracts\Participant;
use Nncodes\Meeting\Contracts\Presenter;
use Nncodes\Meeting\Contracts\Scheduler;
use Nncodes\Meeting\MeetingAdder;
use Nncodes\Meeting\Models\Participant as ParticipantPivot;

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
     * @todo throw an exception when startTime is less then now
     * @param \Carbon\Carbon $startTime
     * @return self
     */
    public function updateStartTime(Carbon $startTime): self
    {
        $now = now();

        if ($startTime->lessThan($now)) {
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
     * @return mixed
     */
    public function getPresenterAccess()
    {
        return $this->instance->getPresenterAccess($this);
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function getParticipantAccess(Participant $participant)
    {
        return $this->instance->getParticipantAccess($this, $participant);
    }

    /**
     * Undocumented function
     *
     * @return \Nncodes\Meeting\Models\Participant|null
     */
    public function getNextParticipant(): ?ParticipantPivot
    {
        return $this->participantsPivot()
                    ->whereNull('started_at')
                    ->whereNull('ended_at')
                    ->orderBy('created_at', 'desc')
                    ->first();
    }

    /**
     * Undocumented function
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if ($updating = $this->exists) {
            $this->instance->updating($this);
        }

        if ($saved = parent::save($options) && $updating) {
            $this->instance->updated($this);

            return $saved;
        }

        return $saved;
    }
}
