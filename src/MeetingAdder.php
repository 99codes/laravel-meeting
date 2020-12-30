<?php

namespace Nncodes\Meeting;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Nncodes\Meeting\Contracts\Host;
use Nncodes\Meeting\Contracts\Presenter;
use Nncodes\Meeting\Contracts\Provider;
use Nncodes\Meeting\Contracts\Scheduler;
use Nncodes\Meeting\Exceptions\BusyForTheMeeting;

class MeetingAdder implements Arrayable
{

    /**
      * @var \Carbon\Carbon
      */
    public Carbon $startTime;

    /**
     * @var int
     */
    public int $duration;

    /**
     * @var string
     */
    public string $topic;

    /**
     * @var \Nncodes\Meeting\Contracts\Scheduler
     */
    public Scheduler $scheduler;

    /**
     * @var \Nncodes\Meeting\Contracts\Host
     */
    public Host $host;

    /**
     * @var \Nncodes\Meeting\Contracts\Presenter
     */
    public Presenter $presenter;

    /**
     * @var \Nncodes\Meeting\Contracts\Provider
     */
    public Provider $provider;


    /**
     * @var array
     */
    public array $metaAttributes = [];

    /**
     * Undocumented function
     *
     * @param string $topic
     * @return self
     */
    public function withTopic(string $topic): self
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
    public function startingAt(Carbon $startTime): self
    {
        $now = now();

        if ($startTime->lessThanOrEqualTo($now)) {
            //@todo exception startTime cannot be less than now
        }

        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param int $minutes
     * @return self
     */
    public function during(int $minutes): self
    {
        $this->duration = $minutes;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Scheduler $scheduler
     * @return self
     */
    public function scheduledBy(Scheduler $scheduler): self
    {
        $this->scheduler = $scheduler;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Host $host
     * @return self
     */
    public function hostedBy(Host $host): self
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param \Nncodes\Meeting\Contracts\Presenter $presenter
     * @return self
     */
    public function presentedBy(Presenter $presenter): self
    {
        $this->presenter = $presenter;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string|null $provider
     * @return self
     */
    public function withProvider(?string $provider = null): self
    {
        $provider = $provider ? $provider : config('meeting.default');

        if (! config('meeting.providers.' . $provider)) {
            throw \Nncodes\Meeting\Exceptions\InvalidProvider::create($provider);
        }

        $provider = resolve("laravel-meeting:{$provider}");

        $this->provider = $provider;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $metaAttributes
     * @return self
     */
    public function withMetaAttributes(array $metaAttributes): self
    {
        $this->metaAttributes = array_merge(
            $metaAttributes,
            $this->metaAttributes
        );

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $settings
     * @throws  \Nncodes\Meeting\Exceptions\BusyForTheMeeting
     * @return void
     */
    protected function preventConcurrent(array $settings)
    {
        $endTime = (clone $this->startTime)->addMinutes($this->duration);

        foreach ($settings as $relation => $allowed) {
            if (! $allowed && isset($this->{$relation})
                && $this->{$relation}->isBusyBetween($this->startTime, $endTime)
            ) {
                throw BusyForTheMeeting::create($this, $relation);
            }
        }
    }

    /**
     * Undocumented function
     *
     * @return Models\Meeting
     */
    public function save(): Models\Meeting
    {
        $this->provider->scheduling($this);

        $this->preventConcurrent(
            config('meeting.allow_concurrent_meetings', [])
        );

        $meeting = new Models\Meeting([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'topic' => $this->topic,
            'start_time' => $this->startTime,
            'duration' => $this->duration,
            'provider' => $this->provider->getFacadeAccessor(),
        ]);

        $meeting->scheduler()->associate($this->scheduler);
        $meeting->presenter()->associate($this->presenter);
        $meeting->host()->associate($this->host);

        $meeting->save();

        foreach ($this->metaAttributes as $key => $value) {
            $meeting->setMeta($key)->value($value);
        }

        $this->provider->scheduled($meeting);

        return $meeting;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'topic' => $this->topic,
            'startTime' => $this->startTime->format('Y-m-d\TH:i:se'),
            'duration' => $this->duration,
            'provider' => $this->provider->getFacadeAccessor(),
            'scheduler' => $this->scheduler,
            'presenter' => $this->presenter,
            'host' => $this->host,
            'metaAttributes' => $this->metaAttributes,
        ];
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Support\Collection
     */
    public function toCollection(): \Illuminate\Support\Collection
    {
        return new Collection($this->toArray());
    }
}
