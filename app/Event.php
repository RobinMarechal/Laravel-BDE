<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Event extends Model {

	protected $table = 'events';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at', 'start', 'end'];
	protected $fillable = array('name', 'user_id', 'validated', 'article', 'team_id', 'start', 'end');

	public function team()
	{
		return $this->belongsTo('App\Team');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function scopeComing($query)
	{
		return $query->where('validated', '1')->where('start', '>=', DB::raw('NOW()'));
	}

	public function scopePast($query)
	{
		return $query->where('validated', '1')->where('start', '<', DB::raw('NOW()'));
	}

}