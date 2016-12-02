<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PictureTag extends Model {

	protected $table = 'picture_tag';
	public $timestamps = false;
	protected $fillable = array('picture_id', 'tag_id');

}