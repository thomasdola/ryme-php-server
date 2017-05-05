<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commercial extends Model
{
    protected $table = "commercials";

    protected $fillable = ["user_id", "ad_id"];
}
