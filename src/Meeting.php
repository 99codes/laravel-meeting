<?php

namespace Nncodes\Meeting;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Nncodes\Meeting\Contracts\Host;
use Nncodes\Meeting\Contracts\Participant as ParticipantContract;
use Nncodes\Meeting\Contracts\Presenter;
use Nncodes\Meeting\Contracts\Provider;
use Nncodes\Meeting\Contracts\Scheduler;
use Nncodes\Meeting\Models\Meeting as MeetingModel;
use Nncodes\Meeting\Models\Participant;

class Meeting
{
    /**
     * Meeting provider class
     *
     * @var \Nncodes\Meeting\Contracts\Provider
     */
    protected Provider $provider;

    /**
     * Create a new meeting instance given the provider
     *
     * @param \Nncodes\Meeting\Contracts\Provider $provider
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
    * Define the custom provider given the facade accessor key
    *
    * @param string $facadeAccessor
    * @return self
    */
    public function provider(string $facadeAccessor): self
    {
        $this->provider = resolve("laravel-meeting:{$facadeAccessor}");

        return $this;
    }

    /**
     * Create a new meeting
     *
     * @param string $topic
     * @param \Carbon\Carbon $startTime
     * @param int $duration duration in minutes
     * @param \Nncodes\Meeting\Contracts\Scheduler $scheduler
     * @param \Nncodes\Meeting\Contracts\Presenter $presenter
     * @param \Nncodes\Meeting\Contracts\Host $host
     * @return mixed
     */
    public function schedule(
        string $topic,
        Carbon $startTime,
        int $duration,
        Scheduler $scheduler,
        Presenter $presenter,
        Host $host
    ) {
        $resource = $this->provider
            ->resource()
            ->setTopic($topic)
            ->setStartTime($startTime)
            ->setDuration($duration)
            ->setScheduler($scheduler)
            ->setPresenter($presenter)
            ->setHost($host)
            ->setProvider(
                $this->provider->facadeAccessor()
            );

        return $this->provider->dispatcher()->schedule($resource);
    }

    /**
     * find a meeting record by uuid
     *
     * @param string $uuid
     * @return \Nncodes\Meeting\Models\Meeting|null
     */
    public function findByUuid(string $uuid): ?MeetingModel
    {
        return MeetingModel::where(['uuid' => $uuid])->first();
    }

    /**
     * Find a meeting record by id
     *
     * @param int $id
     * @return \Nncodes\Meeting\Models\Meeting|null
     */
    public function findById(int $id): ?MeetingModel
    {
        return MeetingModel::find($id);
    }

    /**
     * Get a collection of meetings
     *
     * @param string|null $provider
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollection(?string $provider = null): Collection
    {
        if ($provider) {
            return MeetingModel::where('provider', $provider)->get();
        }

        return MeetingModel::all();
    }

    /**
     * Undocumented function
     *
     * @param int $meetingId
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @return \Nncodes\Meeting\Models\Participant
     */
    public function addParticipant(int $meetingId, ParticipantContract $participant): Participant
    {
        if ($meeting = $this->findById($meetingId)) {
            return $this->provider->dispatcher()->join($meeting, $participant)->pivot;
        }
        //Lançar uma exceção.
    }
}
