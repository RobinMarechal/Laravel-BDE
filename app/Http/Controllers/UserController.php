<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Team;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function teamManaged()
    {
    	if(Auth::guest())
    		return false;

    	$user = Auth::user();

    	if($user->level > 2)
    	{
    		$teams = Team::withTrashed()->get();
    	}
    	else{
    		$teams = $user->teamManaged();
    	}

    	return response()->json($teams);
    }

    public function getData()
    {
        return Auth::check() ? Auth::user() : false;
    }
}
