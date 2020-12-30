<?php

namespace Nncodes\Meeting\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nncodes\Meeting\Models\Meeting;
use Nncodes\Meeting\Models\Traits\VerifiesAvailability;

/**
 * Provides default implementation of Presenter contract.
 */
trait PresentsMeetings
{
    use VerifiesAvailability;
    
    /**
     * Get the MorphMany Relation with the Meeting Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function meetings(): MorphMany
    {
        return $this->morphMany(Meeting::class, 'presenter')->with('scheduler', 'host');
    }
}
