<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlogPost;
class BlogPostController extends Controller
{
    public function getdata(){
    	$id = request()->id;
    	$blog_post = BlogPost::find($id);
    	if($blog_post){
    		$msg['status'] = 1;
    		if($blog_post){
    			$msg['body']   = base64_decode($blog_post->body);
    		}
    		$msg['data']   = $blog_post;
    		return json_encode($msg);
    	}else{
    		$msg['status'] = 0;
    		return json_encode($msg);
    	}
    }
}
