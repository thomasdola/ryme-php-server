<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sessionable extends Model
{
    protected $table = "sessionable";

    protected $fillable = ["ad_session_id", "sessionable_id", "sessionable_type"];

    public function sessionable()
    {
        return $this->morphTo();
    }
}
