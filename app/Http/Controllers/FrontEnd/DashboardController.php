<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlogPost;
class DashboardController extends Controller
{
    public function index(){
    	$blog_post = BlogPost::where('type','notification')->orderBy('id', 'DESC')->first(); 
    	return view('frontend.dashboard.dashboard',compact('blog_post'));
    }
}
