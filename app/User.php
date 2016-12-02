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
	
	// ------ RELATIONS ------

	public function department()
	{
		return $this->belongsTo('App\Department');
	}

	/**
	 * analyzing 'user_id' field in 'teams' table
	 */
	public function teamDirected()
	{
		return $this->hasMany('App\Team')->select(['team_user.validated', 'level', 'teams.id', 'name', 'slug', 'deleted_at']);
	}

	/**
	 * analyzing 'user_id', 'team_id' fields in 'team_user' table, no shit given about team_user.level
	 */
	public function teams()
	{
		return $this->belongsToMany('App\Team')->withPivot(['validated','level'])->where('team_user.validated', 1)->select(['team_user.validated', 'level', 'teams.id', 'name', 'slug', 'deleted_at']);
	}

	/**
	 * analyzing 'user_id', 'team_id' and 'level' fields in 'team_user' table, where team_user.level > 0
	 */
	public function teamManaged()
	{
		return $this->belongsToMany('App\Team')->withPivot(['validated','level'])->where('level', '>', 0)->select(['team_user.validated', 'level', 'teams.id', 'name', 'slug', 'deleted_at']);
	}

	public function news()
	{
		return $this->hasMany('App\News');
	}

	public function events()
	{
		return $this->hasMany('App\Event');
	}

	public function contentsCreated()
	{
		return $this->hasMany('App\Content');
	}

	public function contentsDeleted()
	{
		return $this->hasMany('App\ContentRecord');
	}

	public function notifications()
	{
		return $this->hasMany('App\Notification');
	}

	// ------ HELPERS ------

	public function getNbOfUnseenNotifications()
	{
		$notifications = Notification::where('user_id', $this->id)->where('seen', 0)->orderBy('created_at', 'DESC')->get(['id']);
		return $notifications->count();
	}

	public function hasSeenNotifications()
	{
		return $this->notifications()->where('seen', 0)->update(['seen' => 1]) > 0;
	}

	public function isManaging(Team $team)
	{
		return ($team->user_id == $this->id) || !empty(TeamUser::where('team_id', $team->id)->where('user_id', $this->id)->where('level', '>', 0)->first());
	}
}