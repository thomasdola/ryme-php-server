<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SmsVerificationCode
 * @package App
 */
class SmsVerificationCode extends Model
{
    /**
     * @var string
     */
    protected $table = "sms_verification_codes";

    /**
     * @var array
     */
    protected $fillable = ["user_id", "code", "status"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }
}
