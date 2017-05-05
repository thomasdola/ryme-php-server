<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    /**
     * @var string
     */
    protected $table = 'downloads';

    /**
     * @var array
     */
    protected $fillable = ['track_id', 'user_id'];
}
