<?php

namespace Nncodes\Meeting\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Participant extends MorphPivot
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function participant()
    {
        return $this->morphTo();
    }
}