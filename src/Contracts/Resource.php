<?php

namespace Nncodes\Meeting\Contracts;

use Carbon\Carbon;

interface Resource
{
    public function setTopic(string $topic): self;

    public function setStartTime(Carbon $startTime): self;

    public function setDuration(int $minutes): self;

    public function setPresenter(Presenter $presenter): self;

    public function setScheduler(Scheduler $scheduler): self;

    public function setProvider(string $provider): self;

    public function setHost(Host $host): self;

    public function topic(): string;

    public function startTime(): Carbon;

    public function duration(): int;

    public function presenter(): Presenter;

    public function scheduler(): Scheduler;

    public function host(): Host;

    public function provider(): string;
}
