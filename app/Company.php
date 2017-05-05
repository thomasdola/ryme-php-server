<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = ['name', 'uuid'];

    public function ads()
    {
        return $this->hasMany(Ad::class, 'company_id');
    }
}
