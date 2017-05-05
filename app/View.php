<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class View
 * @package App
 */
class View extends Model
{
    /**
     * @var string
     */
    protected $table = 'views';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'viewable_id', 'viewable_type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function viewable()
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
