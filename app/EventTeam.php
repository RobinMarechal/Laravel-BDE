<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTeam extends Model {

	protected $table = 'event_team';
	public $timestamps = false;
	protected $fillable = array('event_id', 'team_id');

}