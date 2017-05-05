<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdSession extends Model
{
    protected $table = "ad_sessions";

    protected $fillable = ["start_time", "end_time", "name"];

    public function audio_ads()
    {
        return $this->morphedByMany(Ad::class, "sessionable");
    }

    public function event_ads()
    {
        return $this->morphedByMany(Event::class, "sessionable");
    }
}
