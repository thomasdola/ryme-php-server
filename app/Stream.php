<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Stream
 * @package App
 */
class Stream extends Model
{
    /**
     * @var string
     */
    protected $table = 'streams';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'streamable_id', 'streamable_type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function streamable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
