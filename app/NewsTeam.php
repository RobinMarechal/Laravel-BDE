<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsTeam extends Model {

	protected $table = 'news_team';
	public $timestamps = false;
	protected $fillable = array('team_id', 'news_id');

}