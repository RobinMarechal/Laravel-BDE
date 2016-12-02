<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentRecord extends Model
{
	protected $table = 'content_records';
	public $timestamps = true;
	protected $titleField = 'title';

	protected $fillable = array('name', 'user_id', 'content', 'title');

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
