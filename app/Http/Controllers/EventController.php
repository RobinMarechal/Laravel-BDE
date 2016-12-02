<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Event;
use Validator;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index()
    {
        return $this->indexComing();
    }

    public function indexComing()
    {
    	$events = Event::coming()->whereNull('team_id')->with('user')->orderBy('start')->paginate(10);
    	return view('events.indexComing', compact('events'));
    }
    public function indexPast()
    {
    	$events = Event::past()->whereNull('team_id')->with('user')->orderBy('start')->paginate(10);
        return view('events.indexPast', compact('events'));
    }

    public function indexAllComing()
    {
        $events = Event::coming()->with('user', 'team')->orderBy('start')->paginate(10);
    	$all = true;
    	return view('events.indexComing', compact('events', 'all'));
    }

    public function indexAllPast()
    {
    	$events = Event::past()->with('user', 'team')->orderBy('start')->paginate(10);
    	$all = true;
        return view('events.indexPast', compact('events', 'all'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function edit($id)
    {
        $event = Event::withTrashed()->with('team', 'user')->find($id);
        if((Auth::user()->level > 2) || ($event->team_id > 0 && Auth::user()->isManaging($event->team) ) )
        {
            return view('events.edit', compact('event'));
        }

        Flash::error('Vous n\'avez pas les droits suffisants pour accéder à cette page.');
        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $event = Event::find($request->id);

        if(!empty($event))
        {
            $event->delete();
            Flash::success("L'événement a bien été supprimé !");
            return redirect('events');
        }

        Flash::error('Une erreur est survenue, l\'événement n\'a pas été supprimé.');
        return Redirect::back();
    }

    public function trash(Request $request)
    {
        if($request->id == 0)
            return response()->json(false);

        $event = Event::find($request->id);
        if(!empty($event) && $event->delete())
        {
            return response()->json(true);
        }

        return response()->json(false);
    }


    public function restore(Request $request)
    {
        if($request->id == 0)
            return response()->json(false);

        $event = Event::onlyTrashed()->find($request->id);
        if(!empty($event) && $event->restore())
        {
            return response()->json(true);
        }

        return response()->json(false);
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails());
        {
            return Redirect::back()->withInputs()->withErrors($validator->errors());
        }

        if($event = Event::create($request->all()))
        {
            Flash::success("L'événement a bien été créé !");
            return redirect('events/show/'.$event->id);
        }

        Flash::error("Une erreur est survenue, l'événement n'a pas été créé.");
        return Redirect::back();
    }

    
    public function show($id)
    {
        $query = Event::with('user', 'team');
        if(Auth::check() && Auth::user()->level > 1)
        {
            $query = $query->withTrashed();
        }

        $event = $query->find($id);

        if(empty($event))
        {
            abort(404);
        }

        return view('events.show', compact('event'));
    }

    public function ajaxGet($id)
    {
        $event = Event::withTrashed()->find($id);
        return response()->json($event);
    }


    public function update(Request $request)
    {
        $request['start'] = Carbon::createFromFormat('d-m-Y H:i:s', $request->startStr);
        $request['end'] = Carbon::createFromFormat('d-m-Y H:i:s', $request->endStr);

        $validator = $this->validator($request->all());
        if($validator->fails())
        {
            return response()->json(false);
        }

        $event = Event::withTrashed()->find($request->id);


        if(!empty($event) && $event->update($request->all()))
        {
            return response()->json($event);
        }

        return response()->json(false);
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'start' => 'required',
            'end' => 'required',
            'name' => 'required',
            'article' => 'required',
            ]);
    }

    public function ajaxCreate(Request $request)
    {
        if(!$request->ajax())
            abort(404);

        $request['start'] = Carbon::createFromFormat('d-m-Y H:i:s', $request->startStr);
        $request['end'] = Carbon::createFromFormat('d-m-Y H:i:s', $request->endStr);


        $validator = $this->validator($request->all());
        if($validator->fails())
        {
            return response()->json(false);
        }

        $request['user_id'] = Auth::user()->id;
        if($event = Event::create($request->all()))
        {
            return response()->json($event);
        }

        return response()->json(false);
    }
}
