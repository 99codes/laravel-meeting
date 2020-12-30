<?php

namespace Nncodes\Meeting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nncodes\Meeting\Concerns\HostsMeetings;
use Nncodes\Meeting\Contracts\Host;

class MeetingRoom extends Model implements Host
{
    use SoftDeletes;
    use HostsMeetings;

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'uuid' => 'string',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'type',
        'group',
    ];
}
