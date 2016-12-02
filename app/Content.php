<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ContentRecord;

class Content extends Model
{
	protected $table = 'contents';
	protected $titleField = 'title';
	public $timestamps = true;

	protected $fillable = array('name', 'user_id', 'content', 'title');

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function moveToHistory()
	{
		return ContentRecord::create([
			'user_id' => $this->user_id,
			'name'	=> $this->name,
			'content' => $this->content,
			'title' => $this->title 
			]);
	}

	public static function moveToHistoryStatic($name)
	{
		$content = self::where('name', $name)->first();
		return $content->moveToHistory();
	}

	public static function restoreLast($name)
	{
		$content = self::where('name', $name)->first();
		$record = ContentRecord::where('name', $name)->orderBy('id', 'desc')->first();
		$user = User::find($record->user_id);
		if(empty($user))
		{
			$record->user_id = 1;
		}

		return (!empty($content) ? $content->delete() : true) && self::create($record->toArray()) && $record->delete();
	}
}
