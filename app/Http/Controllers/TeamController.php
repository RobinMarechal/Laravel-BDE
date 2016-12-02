<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Validator;
use App\Team;
use App\News;
use App\Content;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index()
    {
    	if(Auth::check())
    		$query = Team::withTrashed()->orderBy('name');
    	else
    		$query = Team::orderBy('name');

    	$teams = $query/*->with('user')*/->where('name', 'NOT LIKE', 'null')->paginate(20);

    	$content = Content::where('name', 'teams_index_content')->first();

    	return view('teams.index', compact('teams', 'content'));
    }

    public function show($slug)
    {
    	$team = Team::with(['user', 'users', 'news' => function($query) { 
    														if(Auth::check() && Auth::user()->level >  1)
    															$query->withTrashed();
    														else
    															$query->where('validated', 1);
                                                            $query->orderBy('id', 'DESC')->limit(3);
                                                         }, 
                                             'events' => function($query) { 
                                                            if(Auth::check() && Auth::user()->level >  1)
                                                                $query->withTrashed();
                                                            else
                                                                $query->where('validated', 1);
                                                            $query->coming()->orderBy('start')->limit(3);
    										 			},
    						]);

        if(is_numeric($slug))
            $team = $team->where('id', $slug);
        else
            $team = $team->where('slug', $slug);

    	if(Auth::check() && Auth::user()->level > 1)
    		$team = $team->withTrashed();

    	$team = $team->first();    

        if(empty($team))
            abort(404);

    	return view('teams.show', compact('team'));

    }

    public function ajaxGet($id)
    {
        $team = Team::withTrashed()->find($id);
        return response()->json($team);
    }

    public function ajaxPost(Request $request)
    {
        $team = Team::withTrashed()->find($request->id);

        if(empty($team))
            return false;

        $team->update($request->all());

        return response()->json($team);

    }


    public function trash(Request $request)
    {
        if($request->id == 0)
            return response()->json(false);

        $team = Team::find($request->id);
        if(!empty($team) && $team->delete())
        {
            return response()->json(true);
        }

        return response()->json(false);
    }


    public function restore(Request $request)
    {
        if($request->id == 0)
            return response()->json(false);

        $team = Team::onlyTrashed()->find($request->id);
        if(!empty($team) && $team->restore())
        {
            return response()->json(true);
        }

        return response()->json(false);
    }

    public function news($slug)
    {
        $team = Team::where('slug', $slug)->with('user')->first();

        $news = News::where('team_id', $team->id)->orderBy('published_at', 'DESC');

        if(Auth::check() && (Auth::user()->level > 2 || Auth::user()->isManaging($team)))
            $team->withTrashed();

        $news = $news->with('user')->paginate(10);

        return view('teams.news', compact('team', 'news'));
    }

    public function ajaxCreate(Request $request)
    {
        if(!$request->ajax())
            abort(404);

        $validator = $this->validator($request->all());
        if($validator->fails())
        {
            return response()->json(false);
        }

        $request['user_id'] = Auth::user()->id;
        if($team = Team::create($request->all()))
        {
            $team->slug = str_slug($team->name).'-'.$team->id;
            $team->save();
            return response()->json($team);
        }

        return response()->json(false);
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'article' => 'required',
            ]);
    }
}
