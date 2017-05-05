<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    /**
     * @var string
     */
    protected $table = 'followings';

    protected $fillable = ['user_id', 'followable_id', 'followable_type'];

    public function followable()
    {
        return $this->morphTo();
    }
}
