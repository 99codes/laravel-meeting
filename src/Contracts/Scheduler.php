<?php

namespace Nncodes\Meeting\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nncodes\Meeting\MeetingAdder;
use Nncodes\Meeting\Models\Meeting;

interface Scheduler
{
    /**
     * Get the MorphMany Relation with the Meeting Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function meetings(): MorphMany;

    /**
    * Undocumented function
    *
    * @param string|null $provider
    * @return \Nncodes\Meeting\MeetingAdder
    */
    public function scheduleMeeting(?string $provider = null): MeetingAdder;

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailableBetween(Builder $query, Carbon $start, Carbon $end, ?Meeting $except = null): Builder;

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBusyBetween(Builder $query, Carbon $start, Carbon $end, ?Meeting $except = null): Builder;

    /**
     * Undocumented function
    *
    * @param \Carbon\Carbon $start
    * @param \Carbon\Carbon $end
    * @param \Nncodes\Meeting\Models\Meeting|null $except
    * @return bool
    */
    public function isAvailableBetween(Carbon $start, Carbon $end, ?Meeting $except = null): bool;

    /**
     * Undocumented function
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return bool
     */
    public function isBusyBetween(Carbon $start, Carbon $end, ?Meeting $except = null): bool;
}
