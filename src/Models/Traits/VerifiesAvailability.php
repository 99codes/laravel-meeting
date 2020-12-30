<?php

namespace Nncodes\Meeting\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Nncodes\Meeting\Models\Meeting;

/**
 * Provides availability verification methods to the meeting instance
 */
trait VerifiesAvailability
{
    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailableBetween(Builder $query, Carbon $start, Carbon $end, ?Meeting $except = null): Builder
    {
        return $query->whereDoesntHave('meetings', function ($query) use ($start, $end, $except) {
            if ($except) {
                $query->where('id', '<>', $except->id);
            }

            $query->where(function ($query) use ($start, $end, $except) {
                $query->where(
                    fn ($q) => $q->startsBetween($start, $end)
                )
                ->orWhere(
                    fn ($q) => $q->endsBetween($start, $end)
                );
            });
        });
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBusyBetween(Builder $query, Carbon $start, Carbon $end, ?Meeting $except = null): Builder
    {
        return $query->whereHas('meetings', function ($query) use ($start, $end, $except) {
            if ($except) {
                $query->where('id', '<>', $except->id);
            }

            $query->where(function ($query) use ($start, $end, $except) {
                $query->where(
                    fn ($q) => $q->startsBetween($start, $end)
                )
                ->orWhere(
                    fn ($q) => $q->endsBetween($start, $end)
                );
            });
        });
    }

    /**
     * Undocumented function
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return bool
     */
    public function isAvailableBetween(Carbon $start, Carbon $end, ?Meeting $except = null): bool
    {
        return get_class($this)::where('id', $this->id)->availableBetween($start, $end, $except)->count() > 0;
    }

    /**
     * Undocumented function
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return bool
     */
    public function isBusyBetween(Carbon $start, Carbon $end, ?Meeting $except = null): bool
    {
        return get_class($this)::where('id', $this->id)->busyBetween($start, $end, $except)->count() > 0;
    }
}
