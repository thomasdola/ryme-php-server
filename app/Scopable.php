<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scopable extends Model
{
    protected $table = "scopables";

    protected $fillable = ["scopable_id", "scopable_type", "category_id"];

    public function scopable()
    {
        return $this->morphTo();
    }
}
