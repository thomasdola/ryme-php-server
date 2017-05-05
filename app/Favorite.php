<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * @var string
     */
    protected $table = 'favorites';

    /**
     * @var array
     */
    protected $fillable = ['track_id', 'user_id'];
}
