<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class News extends Model {

	protected $table = 'news';
	protected $titleField = 'title';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at', 'published_at'];
	protected $fillable = array('title', 'user_id', 'content', 'team_id', 'validated', 'published_at');

	public function team()
	{
		return $this->belongsTo('App\Team');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function scopePublished($query)
	{
		return $query->where('news.validated', '1')->where('news.published_at', '<=', DB::raw('NOW()'));
	}
}