<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model {

	protected $table = 'team_user';
	public $timestamps = true;
	protected $fillable = array('user_id', 'team_id', 'validated', 'level');

}