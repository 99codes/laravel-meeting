<?php

namespace Nncodes\Meeting\Providers\Database;

use Carbon\Carbon;
use Nncodes\Meeting\Contracts\Resource as Contract;
use Nncodes\Meeting\Contracts\Host;
use Nncodes\Meeting\Contracts\Presenter;
use Nncodes\Meeting\Contracts\Scheduler;

class Resource implements Contract
{  
   /**
     * @var \Carbon\Carbon $startTime 
     */
    protected Carbon $startTime;

    /**
     * @var int $duration
     */
    protected int $duration;

    /**
     * @var string $topic
     */
    protected string $topic;

    /**
     * @var \Nncodes\Meeting\Contracts\Scheduler $scheduler
     */
    protected Scheduler $scheduler;

    /**
     * @var \Nncodes\Meeting\Contracts\Host $host
     */
    protected Host $host;

    /**
     * @var \Nncodes\Meeting\Contracts\Presenter $presenter
     */
    protected Presenter $presenter;

    /**
     * @var string
     */
    protected string $provider;

    /**
     * Undocumented function
     *
     * @param string $topic
     * @return self
     */
    public function setTopic(string $topic): self
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
    public function setStartTime(Carbon $startTime): self
    {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param integer $minutes
     * @return self
     */
    public function setDuration(int $minutes): self
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
    public function setScheduler(Scheduler $scheduler): self
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
    public function setHost(Host $host): self
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
    public function setPresenter(Presenter $presenter): self
    {
        $this->presenter = $presenter;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $provider
     * @return self
     */
    public function setProvider(string $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function topic(): string
    {
        return $this->topic;
    }

    /**
     * Undocumented function
     *
     * @return \Carbon\Carbon
     */
    public function startTime(): Carbon
    {
        return $this->startTime;
    }

    /**
     * Undocumented function
     *
     * @return integer
     */
    public function duration(): int
    {
        return $this->duration;
    }

    /**
     * Undocumented function
     *
     * @return \Nncodes\Meeting\Contracts\Scheduler
     */
    public function scheduler(): Scheduler
    {
        return $this->scheduler;
    }

    /**
     * Undocumented function
     *
     * @return \Nncodes\Meeting\Contracts\Presenter
     */
    public function presenter(): Presenter
    {
        return $this->presenter;
    }

    /**
     * Undocumented function
     *
     * @return \Nncodes\Meeting\Contracts\Host
     */
    public function host(): Host
    {
        return $this->host;        
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function provider(): string
    {
        return $this->provider;
    }

}