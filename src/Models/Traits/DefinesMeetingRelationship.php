<?php

namespace Nncodes\Meeting\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nncodes\Meeting\Models\Participant;

/**
 * Provides relationship methods for meeting model
 */
trait DefinesMeetingRelationship
{
    /**
     * Get the MorphTo Relation with the scheduler models
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function scheduler(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the MorphTo Relation with the host model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function host(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the MorphTo Relation with the presenter models
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function presenter(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the MorphToMany Relation with the participant models
     *
     * @param string $modelType
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function participants(string $modelType): MorphToMany
    {
        return $this->morphedByMany($modelType, 'participant', 'meeting_participants')
                    ->using(Participant::class)
                    ->withPivot(['uuid', 'started_at', 'ended_at'])
                    ->withTimestamps();
    }

    /**
     * Get the hasMany relationship with the participants pivot model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participantsPivot(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}
