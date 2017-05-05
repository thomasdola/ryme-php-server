<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdSection extends Model
{
    protected $table = "ad_sections";

    protected $fillable = ["start_time", "end_time", "name"];

    protected $hidden = ['created_at', 'updated_at', 'id'];

    public function audio_ads()
    {
        return $this->morphedByMany(Ad::class, "sectionable");
    }

    public function event_ads()
    {
        return $this->morphedByMany(Event::class, "sectionable");
    }
}
