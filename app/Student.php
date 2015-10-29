<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    // fields that are mass-fillable
	protected $fillable = ['id', 'name', 'address', 'phone', 'career'];

    // fields that can't be changed via the API
	protected $hidden = ['created_at', 'updated_at'];


    // relationship to COURSES
    // a student can have many courses
	public function courses()
	{
		return $this->belongsToMany('App\Course');
	}

}