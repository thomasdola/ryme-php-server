<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    /**
     * @var string
     */
    protected $table = 'ads';

    /**
     * @var array
     */
    protected $fillable = ['title', 'uuid', 'start_date', 'end_date', 'is_active', 'company_id', 'is_section_active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function streams()
    {
        return $this->morphMany(Stream::class, 'streamable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function file()
    {
       return $this->morphOne(File::class, 'filable');
    }

    public function artists()
    {
        return $this->belongsToMany(User::class, "commercials", "ad_id", "user_id");
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, "scopable")->withTimestamps();
    }

    public function sessions()
    {
        return $this->morphToMany(AdSession::class, "sessionable")->withTimestamps();
    }

    public function sections()
    {
        return $this->morphToMany(AdSection::class, "sectionable")->withTimestamps();
    }
}
