<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'schedule', 'start_date', 'end_date'];

    /**
     * Get students belongs to course
     * @return App\Student
     */
    public function students()
    {
        return $this->belongsToMany('App\Student')->withTimestamps();
    }
}
