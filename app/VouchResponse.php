<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VouchResponse
 * @package App
 */
class VouchResponse extends Model
{
    /**
     * @var string
     */
    protected $table = 'vouch_responses';

    /**
     * @var array
     */
    protected $fillable = ['vouch_id', 'user_id', 'answer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vouch()
    {
        return $this->belongsTo(Vouch::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
