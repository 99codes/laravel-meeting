<?php

namespace Nncodes\Meeting\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Scheduler
{
    /**
     * Get the MorphMany Relation with the Meeting Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function meetings(): MorphMany;
}
