<?php

namespace Nncodes\Meeting\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Nncodes\Meeting\Contracts\Host;
use Nncodes\Meeting\Contracts\Participant;
use Nncodes\Meeting\Contracts\Presenter;
use Nncodes\Meeting\Contracts\Scheduler;

/**
 * Provides scoped methods to query a meeting
 */
trait QueriesMeeting
{
    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUuid(Builder $query, string $uuid): Builder
    {
        return $query->where($this->getTable() . '.uuid', $uuid);
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeById(Builder $query, int $id): Builder
    {
        return $query->where($this->getTable() . '.id', $id);
    }

    /**
     * Scope a query to filter by scheduler
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Nncodes\Meeting\Contracts\Scheduler $scheduler
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduler(Builder $query, Scheduler $scheduler): Builder
    {
        return $query->whereHasMorph(
            'scheduler',
            get_class($scheduler),
            fn (Builder $query) => $query->where('id', $scheduler->id)
        );
    }

    /**
     * Scope a query to filter by presenter
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Nncodes\Meeting\Contracts\Presenter $presenter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePresenter(Builder $query, Presenter $presenter): Builder
    {
        return $query->whereHasMorph(
            'presenter',
            get_class($presenter),
            fn (Builder $query) => $query->where('id', $presenter->id)
        );
    }

    /**
     * Scope a query to filter by host
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Nncodes\Meeting\Contracts\Host $host
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHost(Builder $query, Host $host): Builder
    {
        return $query->whereHasMorph(
            'host',
            get_class($host),
            fn (Builder $query) => $query->where('id', $host->id)
        );
    }

    /**
     * Scope a query to filter by participant
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Nncodes\Meeting\Contracts\Participant $participant
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParticipant(Builder $query, Participant $participant): Builder
    {
        return $query->whereHas(
            'participantsPivot',
            fn (Builder $query) => $query->where([
                'participant_id' => $participant->id,
            ])
        );
    }

    /**
     * Scope a query to filter by start_time between dates
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStartsBetween(Builder $query, Carbon $start, Carbon $end): Builder
    {
        return $query->whereBetween($this->getTable(). '.start_time', [
            $start->format('Y-m-d H:i:s'),
            $end->format('Y-m-d H:i:s'),
        ]);
    }

    /**
    * Scope a query to filter by start_time plus duration between dates
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @param \Carbon\Carbon $start
    * @param \Carbon\Carbon $end
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeEndsBetween(Builder $query, Carbon $start, Carbon $end): Builder
    {
        return $query->whereBetween(DB::raw('DATE_ADD('.$this->getTable().'.start_time, INTERVAL '.$this->getTable().'.duration MINUTE)'), [
            $start->format('Y-m-d H:i:s'),
            $end->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Scope a query to filter by start_time period from
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $start
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStartsFrom(Builder $query, Carbon $start): Builder
    {
        return $query->where($this->getTable() . '.start_time', '>=', $start->format('Y-m-d H:i:s'));
    }

    /**
     * Scope a query to filter by start_time period until
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $end
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStartsUntil(Builder $query, Carbon $end): Builder
    {
        return $query->where($this->getTable() . '.start_time', '<=', $end->format('Y-m-d H:i:s'));
    }

    /**
     * Scope a query to filter by provider
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $provider
     * @throws \Nncodes\Meeting\Exceptions\InvalidProvider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProvider(Builder $query, string $provider): Builder
    {
        if (config('meeting.providers.' . $provider)) {
            return $query->where($this->getTable() . '.provider', $provider);
        }

        throw \Nncodes\Meeting\Exceptions\InvalidProvider::create($provider);
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduled(Builder $query): Builder
    {
        return $query->whereNull([$this->getTable() . '.started_at', $this->getTable() . '.ended_at']);
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLate(Builder $query): Builder
    {
        return $query->scheduled()->whereDate('start_time', '<', now()->format('Y-m-d H:i:s'));
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExceeded(Builder $query): Builder
    {
        return $query->live()->where(
            DB::raw('DATE_ADD('.$this->getTable().'.started_at, INTERVAL '.$this->getTable().'.duration MINUTE)'),
            '<',
            now()->format('Y-m-d H:i:s')
        );
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePast(Builder $query): Builder
    {
        return $query->whereNotNull([$this->getTable() . '.started_at', $this->getTable() . '.ended_at']);
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLive(Builder $query): Builder
    {
        return $query->whereNotNull($this->getTable() . '.started_at')->whereNull($this->getTable() . '.ended_at');
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNext(Builder $query): Builder
    {
        return $query->scheduled()->orderBy($this->getTable() . '.start_time', 'asc');
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLast(Builder $query): Builder
    {
        return $query->past()->orderBy($this->getTable() . '.ended_at', 'desc');
    }
}
