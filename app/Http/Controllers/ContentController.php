<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Content;

class ContentController extends Controller
{
    public function getContent($name)
    {
    	$content = Content::where('name', $name)->first();

    	return response()->json($content);
    }

    public function post(Request $request)
    {
        $content = Content::where('name', $request->name)->first();

        if(!empty($content))
        {
            if($content->moveToHistory())
            {       
                $request->user_id = Auth::user()->id;
                $content->update($request->all());
			}
			else
			{
				return false;
			}
    	}else
    	{
			$request->user_id = Auth::user()->id;
			$content = Content::create($request->all());
    	}

    	return response()->json($content);
    }
}
