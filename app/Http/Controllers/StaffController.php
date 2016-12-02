<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    public function index()
    {
    	$content = Content::where('name', 'staff_content')->first();
    	return view('staff.index', compact('content'));
    }
}
