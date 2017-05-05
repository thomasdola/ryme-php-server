<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vouch extends Model
{
    /**
     * @var string
     */
    protected $table = 'vouches';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'start_date', 'end_date', 'is_active', 'uuid'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses()
    {
        return $this->hasMany(VouchResponse::class, 'vouch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function channel()
    {
        return $this->morphOne(NotificationChannel::class, 'channelable');
    }
}
