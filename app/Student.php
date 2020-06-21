<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['firstname', 'lastname','email', 'birthdate'];

    /**
     * Get courses belongs to student
     * @return App\Course
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }
}
