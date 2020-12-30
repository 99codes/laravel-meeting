<?php

namespace Nncodes\Meeting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nncodes\MetaAttributes\Concerns\HasMetaAttributes;

class Meeting extends Model
{
    use SoftDeletes;
    use HasMetaAttributes;
    use Traits\QueriesMeeting;
    use Traits\DefinesMeetingRelationship;
    use Traits\ManipulatesParticipants;
    use Traits\ProvidesMeetingAccessors;
    use Traits\ManipulatesMeeting;
    
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
        'provider',
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'start_time' => 'datetime:Y-m-d\TH:i:se',
        'started_at' => 'datetime:Y-m-d\TH:i:se',
        'ended_at' => 'datetime:Y-m-d\TH:i:se',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'scheduler_type',
        'scheduler_id',
        'host_type',
        'host_id',
        'presenter_type',
        'presenter_id',
    ];

    /**
    * The relationships that should always be loaded.
    *
    * @var array
    */
    protected $with = [
        'scheduler',
        'presenter',
        'host',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'end_time',
        'elapsed_time',
    ];
}
