<?php

namespace App;

use App\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Event extends Model
{
    /**
     * @var string
     */
    protected $table = 'events';

    /**
     * @var array
     */
    protected $fillable = ['title', 'uuid', 'venue', 'fare',
        'description', 'date_time', 'start_date',
        'end_date', 'is_active', 'company_id', 'is_section_active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function photo()
    {
        return $this->morphOne(Photo::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
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
