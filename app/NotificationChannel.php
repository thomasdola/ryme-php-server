<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationChannel extends Model
{
    protected $table = 'notification_channels';

    protected $fillable = ['name', 'uuid', 'channelable_id', 'channelable_type'];

    public function channelable()
    {
        return $this->morphTo();
    }
}
