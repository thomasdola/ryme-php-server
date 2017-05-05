<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * @var string
     */
    protected $table = 'photos';

    /**
     * @var array
     */
    protected $fillable = ['path', 'type', 'imageable_id', 'imageable_type', "uuid", "extension"];

    public function imageable()
    {
        return $this->morphTo();
    }
}
