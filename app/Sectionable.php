<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectionable extends Model
{
    protected $table = "sectionables";

    protected $fillable = ['ad_section_id', 'sectionable_id', 'sectionable_type'];

    public function sectionable()
    {
        return $this->morphTo();
    }
}
