<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends Model {

	protected $table = 'pictures';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('name', 'legend', 'user_id', 'path', 'team_id', 'event_id', 'news_id');

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function tags()
	{
		return $this->belongsToMany('App\Tag');
	}

	public function team()
	{
		return $this->belongsTo('App\Team');
	}

	public function news()
	{
		return $this->belongsTo('App\News');
	}

	public function event()
	{
		return $this->belongsTo('App\Event');
	}

}