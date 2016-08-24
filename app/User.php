<?php
namespace App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
	use SoftDeletes;
    
	protected $table = 'users';
	public $timestamps = true;
	protected $dates = ['deleted_at'];
	protected $fillable = array('first_name', 'last_name', 'password', 'level', 'email', 'school_year', 'department_id', 'validated');
	
	public function department()
	{
		return $this->belongsTo('App\Department');
	}

	public function teams()
	{
		return $this->belongsToMany('App\Team')->withPivot(['validated','level']);
	}

	public function news()
	{
		return $this->hasMany('App\News');
	}

	public function events()
	{
		return $this->hasMany('App\Event');
	}


}