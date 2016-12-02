<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

	protected $table = 'notifications';
	public $timestamps = true;
	protected $fillable = array('content', 'link', 'user_id', 'seen', 'updated_at');

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function send(array $notifications) // [[ user_id, content, link ], [user_id, content, link], ... ] OR [user_id, content, link]
	{
		if(!is_array($notifications[0]) && array_key_exists('content', $notifications) && array_key_exists('user_id', $notifications) && array_key_exists('link', $notifications))
		{
			$this->create($notifications);
			return true;
		}
		else
		{
			foreach ($notifications as $notif) {
				$this->create($notif);
			}
			return true;
		}

		return false;
	}
}
