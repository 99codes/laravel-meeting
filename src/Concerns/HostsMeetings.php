<?php

namespace Nncodes\Meeting\Concerns;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nncodes\Meeting\Contracts\Host;
use Nncodes\Meeting\Models\Meeting;
use Nncodes\Meeting\Models\Traits\VerifiesAvailability;

/**
 * Provides default implementation of Host contract.
 */
trait HostsMeetings
{
    use VerifiesAvailability;
    
    /**
     * Get the MorphMany Relation with the Meeting Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function meetings(): MorphMany
    {
        return  $this->morphMany(Meeting::class, 'host')->with('scheduler', 'presenter');
    }

    /**
     * Undocumented function
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param \Nncodes\Meeting\Models\Meeting|null $except
     * @return \Nncodes\Meeting\Contracts\Host|null
     */
    public static function findAvailable(Carbon $start, Carbon $end, ?Meeting $except = null): ?Host
    {
        return static::availableBetween($start, $end, $except)->inRandomOrder()->first();
    }
}
