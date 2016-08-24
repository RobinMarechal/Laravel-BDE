<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

	protected $table = 'departments';
	public $timestamps = false;
	protected $fillable = array('name', 'short_name');

	public function users()
	{
		return $this->hasMany('App\User');
	}

}