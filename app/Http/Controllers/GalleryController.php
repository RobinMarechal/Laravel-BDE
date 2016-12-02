<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Picture;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
    	$pictures = Picture::with('tags', 'user')->paginate(20);
    	return view('gallery.index', compact('pictures'));
    }
}
