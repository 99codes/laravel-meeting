<?php

namespace Nncodes\Meeting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nncodes\Meeting\Meeting as LaravelMeeting;
use Nncodes\Meeting\MeetingFacade;

class Meeting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'topic', 
        'start_time',
        'duration',
        'started_at',
        'ended_at',
        'provider'
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_time' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'scheduler_type', 'scheduler_id',
        'host_type', 'host_id',
        'presenter_type', 'presenter_id',
    ];

     /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['scheduler', 'presenter', 'host'];

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
                    ->withPivot('uuid');
    }

    /**
     * Get the provider instance for current record
     *
     * @return \Nncodes\Meeting\Meeting|null
     */
    public function provider(): ?LaravelMeeting
    {
        if( !is_null($this->provider) ){
            return MeetingFacade::provider($this->provider);
        }
    }
    
}
