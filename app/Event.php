<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model {

	protected $table = 'events';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('name', 'user_id', 'validated', 'article', 'team');

	public function teams()
	{
		return $this->belongsToMany('App\Team');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

}