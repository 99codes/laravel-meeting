<?php

namespace Nncodes\Meeting\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nncodes\Meeting\Models\Meeting;

trait HostsMeetings
{
   /**
    * Get the MorphMany Relation with the Meeting Model
    *
    * @return \Illuminate\Database\Eloquent\Relations\MorphMany
    */
    public function meetings(): MorphMany
    {
        return  $this->morphMany(Meeting::class, 'host')->with('scheduler', 'presenter');
    }
}