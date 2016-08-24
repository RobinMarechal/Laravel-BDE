<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model {

	protected $table = 'news';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('title', 'user_id', 'content', 'team', 'validated');

	public function teams()
	{
		return $this->belongsToMany('App\Team');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

}