<?php

namespace Nncodes\Meeting\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Nncodes\MetaAttributes\Concerns\HasMetaAttributes;

class Participant extends MorphPivot
{
    use HasMetaAttributes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meeting_participants';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'started_at' => 'datetime:Y-m-d\TH:i:se',
        'ended_at' => 'datetime:Y-m-d\TH:i:se',
    ];

    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function participant(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Undocumented function
     *
     * @return self
     */
    public function join(): self
    {
        $joinTime = $this->started_at ?? now();
        $this->fill(['started_at' => $joinTime])->save();

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return self
     */
    public function leave(): self
    {
        $leaveTime = $this->ended_at ?? now();
        $this->fill(['ended_at' => $leaveTime])->save();

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return bool
     */
    public function cancel(): bool
    {
        return $this->delete();
    }
}
