<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Validator;
use App\News;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
	public function indexAll()
	{

		$selects = ['teams.id AS team_id',
				 	'teams.name AS team_name',
				  	'teams.slug AS team_slug',
				  	'teams.deleted_at AS team_deleted_at',
				   	'news.id AS news_id',
				   	'news.title AS news_title',
				   	'news.content AS news_content',
				   	'news.published_at AS news_published_at',
				   	'news.deleted_at AS news_deleted_at',
				   	'users.id AS user_id',
				   	'users.first_name AS user_first_name',
				   	'users.last_name AS user_last_name'
				   	];


		// $news = News::published()->with(['team' => function($query) { $query-> } , 'user'])->orderBy('published_at')->paginate(10);
		$news = News::published()
				->join('users', 'users.id', '=', 'news.user_id')
				->join('teams', 'teams.id', '=', 'news.team_id')
				->whereNotNull('news.team_id')
				->whereNull('teams.deleted_at')
				->orderBy('published_at', 'DESC');

		if(Auth::check() && Auth::user()->level > 2)
			$news = $news->withTrashed();
			
		$news = $news->paginate(10, $selects);

		// dd($news);

		return view('news.indexAll', compact('news'));
	}

	
	public function index()
	{
		$news = News::published()->with('user')->whereNull('team_id')->orderBy('published_at', 'DESC');
		
		if(Auth::check() && Auth::user()->level > 2)
			$news = $news->withTrashed();
		
		$news = $news->paginate(10);
		return view('news.index', compact('news'));
	}

	
	public function show($id)
	{
		$query = News::with('user', 'team');
		if(Auth::check() && Auth::user()->level > 1)
		{
			$query = $query->withTrashed();
		}
		else
		{
			$query = $query->published();
		}

		$news = $query->find($id);

		if(empty($news))
		{
			abort(404);
		}

		return view('news.show', compact('news'));
	}

	public function ajaxGet($id)
	{
		$news = News::withTrashed()->find($id);
		return response()->json($news);
	}

	
	public function create()
	{
		return view('news.create');
	}

	
	public function edit($id)
	{
		$news = News::withTrashed()->with('team', 'user')->find($id);
		if((Auth::user()->level > 2) || ($news->team_id > 0 && Auth::user()->isManaging($news->team) ) )
		{
			return view('news.edit', compact('news'));
		}

		Flash::error('Vous n\'avez pas les droits suffisants pour accéder à cette page.');
		return Redirect::back();
	}

   
	public function update(Request $request)
	{
		if($request->ajax())
		{
			$request['published_at'] = new Carbon($request->published_at);
			$validator = $this->validator($request->all());
			if($validator->fails())
			{
				return response()->json(false);
			}

			$news = News::withTrashed()->find($request->id);

			if(!empty($news) && $news->update($request->all()))
			{
				return response()->json($news);
			}

			return response()->json(false);
		}
		else
		{
			$validator = $this->validator($request->all());
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors())->withInput();          
			}

			$news = News::withTrashed()->find($request->id);

			if($news->update($request->all()))
			{
				Flash::success('La news a bien été modifiée !');
				return redirect('news/show/'.$news->id);
			}

			Flash::error('Erreur : impossible de modifier la news. Veuillez réessayer');
			return Redirect::back();
		}
	}

   
	public function store(Request $request)
	{
		if($request->ajax())
		{
			$request['published_at'] = new Carbon($request->published_at);
			$validator = $this->validator($request->all());
			if($validator->fails())
			{
				return response()->json(false);
			}

			$request['team_id'] = $request->team_id == 0 ? null : $request->team_id;
			$request['user_id'] = Auth::user()->id;

			if($news = news::create($request->all()))
			{
				return response()->json($news);
			}

			return response()->json(false);
		}
		else
		{
			$validator = $this->validator($request->all());
			if($validator->fails())
			{
				return Redirect::back()->withErrors($validator->errors())->withInput();          
			}

			if(isset($request->team_id))
			{
				$request['team'] = 1;
			}

			if($news = news::create($request->all()))
			{
				Flash::success('La news a bien été créée !');
				return redirect('news/show/'.$news->id);
			}

			Flash::error('Erreur : impossible de créer la news. Veuillez réessayer');
			return Redirect::back();
		}
	}

   
	// public function delete(Request $request)
	// {
	// 	$news = $news->find($request->id);
	// 	if(!empty($news))
	// 	{
	// 		$news->delete();
	// 		Flash::success('La news a bien été supprimée !');
	// 		return redirect('/news');
	// 	}

	// 	Flash::error('Une erreur est survenue. Veuillez recharger la page puis réessayez.');
	// 	return Redirect::back();
	// }

   
	// public function restore(Request $request)
	// {
	// 	$news = News::onlyTrashed()->find($request->id);
	// 	if(!empty($news))
	// 	{
	// 		$news->restore();
	// 		Flash::success('La news a bien été restaurée !');
	// 		return redirect('/news/show/'.$news->id);
	// 	}

	// 	Flash::error('Une erreur est survenue. Veuillez recharger la page puis réessayez.');
	// 	return Redirect::back();
	// }

   
	public function toggleValidation(Request $request)
	{
		$bool = News::toggleValidation($request->id);
		if($bool)
		{
			Flash::success('La news a bien été mise à jour !');
			return Redirect::back();
		}

		Flash::error('Impossible de modifier la news. Veuillez recharger et réessayez.');
		return Redirect::back();
	}

   
	public function validator($array)       
	{
		return Validator::make($array, [
			'published_at' => 'required|date',
			'title' => 'required|max:255',
			'content' => 'required',
			]);
	}

	public function trash(Request $request)
	{
		if($request->id == 0)
			return response()->json(false);

		$news = News::find($request->id);
		if(!empty($news) && $news->delete())
		{
			return response()->json(true);
		}

		return response()->json(false);
	}


	public function restore(Request $request)
	{
		if($request->id == 0)
			return response()->json(false);

		$news = News::onlyTrashed()->find($request->id);
		if(!empty($news) && $news->restore())
		{
			return response()->json(true);
		}

		return response()->json(false);
	}
}
