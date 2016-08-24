<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model {

	protected $table = 'teams';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('name', 'article', 'validated', 'user_id');

	public function events()
	{
		return $this->belongsToMany('App\Event');
	}

	public function news()
	{
		return $this->belongsToMany('App\News');
	}

	public function users()
	{
		return $this->belongsToMany('App\User')->withPivot(['validated','level']);
	}

}