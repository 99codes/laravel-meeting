<?php

namespace Nncodes\Meeting\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Participant
{
    /**
     * Get the MorphToMany Relation with the Meeting Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function meetings(): MorphToMany;
}
