<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use DataTables;
use App\BlogPostRelationship;
use App\Country;
use App\Shopaholic;
use App\User;
use App\ShopaholicGroup;
use JavaScript;
use Auth;

class BlogPostController extends Controller
{

	function __construct()
    {
    	JavaScript::put([
			'del_url' => route('blog_post.delete'),
		]);

    }
    public function index(){
    	
    	//$users = User::limit(10)->get();
    	
    	return view('blog-post.index');
    }
    public function getBlogPost(){
		$posts 	= BlogPost::select('*');
		return DataTables::of($posts)
			->editColumn('status', function ($post) {
				if ($post->status == 'active') {
					return '<label class="label label-primary">Active</label>';
				}
				if ($post->status == 'inactive') {
					return '<label class="label label-danger">Inactive</label>';
				}
			})
			->editColumn('type', function ($post) {
					return '<label class="label label-primary">'.$post->type.'</label>';
			})
			->editColumn('created_by', function ($post) {
				return $post->user->first_name.' '.$post->user->last_name;
			})
			->rawColumns(['status', 'action','created_by','type'])
			->addColumn('action', function ($post) {
				return view('blog-post.action-buttons', ['result' => $post, 'modal_id' => 'EditCountryModel','assign_country_id'=>'assign_country_modal','assign_user_id'=>'assign_user_modal'])->render();
			})->make(true);
    }

    public function create(){
    	$countries = Country::all();
    	$group_shopaholics = ShopaholicGroup::where('type','shopaholic')->get();
    	return view('blog-post.add-post',compact('countries','group_shopaholics'));
    }
    public function imageStore(Request $request){
    	if ($request->hasFile('file')) {

			$file = $request->file("file");

			$file_unique_name = 'editor' . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();

			$is = $file->storeAs(config('constants.img_folder'), $file_unique_name);
			$msg['status'] = 1;
			$msg['url'] = route('img_file',$file_unique_name);
			return json_encode($msg);
		}
    }

    public function store(){ 
    	
    	$validatedData 	= 	request()->validate([
			'title' 	=> 	'required',
			'type' 		=> 	'required',
			'status' 	=> 	'required',
			'summary'   => 'required',
		]);
		$blog_post = new BlogPost;
		if(request()->file){
			$file = request()->file("file");
			$file_unique_name = 'editor' . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
			$is = $file->storeAs(config('constants.img_folder'), $file_unique_name);
			$blog_post->img_name = $file_unique_name;
		}
		$blog_post->title = request()->title;
		$blog_post->type  = request()->type;
		$blog_post->status = request()->status;
		$blog_post->summary = request()->summary;
		$blog_post->body   = htmlspecialchars(request()->body);
		$blog_post->created_by = Auth::user()->id;
		$is_saved = $blog_post->save();
		if($is_saved){
			if(!empty(request()->shopaholic_group) || !empty(request()->shopaholics) || !empty(request()->country)){
				
				if(!empty(request()->shopaholic_group)){
					foreach (request()->shopaholic_group as $key => $value) {
						$blog_shopaholic_group_relation 				= 	new BlogPostRelationship;
						$blog_shopaholic_group_relation->object_id 		= 	$value;
						$blog_shopaholic_group_relation->type      		= 	'shopaholic_group';
						$blog_shopaholic_group_relation->blog_post_id 	= 	$blog_post->id;
						$blog_shopaholic_group_relation->save(); 
					}
				}
				if(!empty(request()->shopaholics)){
					foreach (request()->shopaholics as $key => $value) {
						$blog_shopaholic_relation 				= 	new BlogPostRelationship;
						$blog_shopaholic_relation->object_id 	= 	$value;
						$blog_shopaholic_relation->type      	= 	'shopaholic';
						$blog_shopaholic_relation->blog_post_id = 	$blog_post->id;
						$blog_shopaholic_relation->save();
					}
				}
				if(!empty(request()->country)){
					foreach (request()->country as $key => $value) {
						$blog_country_relation 					= 	new BlogPostRelationship;
						$blog_country_relation->object_id 		= 	$value;
						$blog_country_relation->type     		= 	'country';
						$blog_country_relation->blog_post_id 	= 	$blog_post->id;
						$blog_country_relation->save();
					}
				}
			}

			$msg['status'] = 1;
			return json_encode($msg);
		}else{
			$msg['status'] = 0;
			return json_encode($msg);
		}
    }

    public function assignPost($type){
    	if($type == 'country'){
	    	$validatedData 	= 	request()->validate([
				'country' 		=> 	'required',
			]);
			$id = request()->id;
			$blog_post = BlogPost::where('id',$id)->first();
			$blog_post->blogPostCountry()->delete();
			foreach(request()->country as $country_id){
				$blog_post_relation = new BlogPostRelationship; 
				$blog_post_relation->object_id = $country_id;
				$blog_post_relation->type = 'country';
				$blog_post->blogPostCountry()->save($blog_post_relation);
			}
			$msg['status'] = 1;
			return json_encode($msg);
			exit;
    	}

    	if($type == 'user'){
	    	$validatedData 	= 	request()->validate([
				'user' 		=> 	'required',
			]);
			$id = request()->id;
			$blog_post = BlogPost::where('id',$id)->first();
			$is_deleted = $blog_post->blogPostShopaholic()->delete(); 
			foreach(request()->user as $user_id){
			$blog_post_relation = new BlogPostRelationship; 
			$blog_post_relation->object_id = $user_id;
			$blog_post_relation->type = 'shopaholic';
			$blog_post->blogPostShopaholic()->save($blog_post_relation);
			}
			$msg['status'] = 1;
			return json_encode($msg);
			exit; 
			
    	}
    }
    public function assignEditPost(){
    	if(request()->type == 'country'){
			$id = request()->id;
			$blog_post = BlogPost::where('id',$id)->with('blogPostCountry.country')->first();
			$arr_country  = [];
			foreach($blog_post->blogPostCountry as $relation){
				$arr_country[] = $relation->country->id;
			}
			$msg['status'] = 1;
			$msg['country_id'] = $arr_country;
			return json_encode($msg);
    	}
    	if(request()->type == 'user'){
			$id = request()->id;
			$blog_post = BlogPost::where('id',$id)->with('blogPostShopaholic.user.shopaholic')->first();
			$arr_user  = [];
			foreach($blog_post->blogPostShopaholic as $relation){
				$arr_user[] = $relation->user;

			}
			$msg['status'] = 1;
			$msg['users'] = $arr_user;
			$msg['num_of_ids'] = sizeof($arr_user);
			return json_encode($msg);
    	}
    }

    public function searchUser(){ 
    	$search = request()->q;
    	// if(stripos($search,'sn-') !==false){
    	// 	$arr= explode("-",$search);
    	// 	$result = shopaholic::where('sn','"'.$search.'"')->get();
    	// 	return json_encode($result);exit;
    	// }
    	/*$result = User::select('first_name','last_name','id','email','status')
    				->with('shopaholic')
    				->whereHas('shopaholic',function($qry) use($search){
    					$qry->where('sn', 'like',$search.'%');
    				})
    				->with('roles')
    				->whereHas('roles',function($qry){
    					$qry->where('name', 'shopaholic');
    				})
    				->where('first_name','like',$search.'%')
    				->orWhere('last_name','like',$search.'%')
    				->limit(20)
    				->get();*/

    	$result = Shopaholic::where('user_id','!=','')
    				->with('user')
    				->whereHas('user',function($qry) use($search){
    					$qry->where('first_name','like',$search.'%');
    					$qry->orWhere('last_name','like',$search.'%');
    					$qry->orWhere('email','like',$search.'%');
    				})
    				->orWhere('sn','like',$search.'%')    				
    				->limit(20)
    				->get();

    	return json_encode($result);
    }

    public function changeStatus(){ 
		$id =  request()->id;
		$blog_post = BlogPost::find($id);
		$blog_post->status = request()->status;
		$is_update = $blog_post->update();
		if ($is_update) {
			$msg['status'] = 1;
			return json_encode($msg);
		} else {
			$msg['status'] = 0;
			return json_encode($msg);
		} 
    }

    public function edit($id){
    	$countries = Country::all();
    	$blog_post = BlogPost::where('id',$id)->with('blogPostShopaholic.shopaholic.user')->first(); 
    	$group_shopaholics = ShopaholicGroup::where('type','shopaholic')->get();  
    	return view('blog-post.edit-post',compact('countries','blog_post','group_shopaholics'));
    }

    public function update(){ 
    	$validatedData 		= 	request()->validate([
			'title' 		=> 	'required',
			'type' 			=> 	'required',
			'status' 		=> 	'required',
			'summary'       =>  'required',
		]);
    	$id 				= 	request()->id;
    	$blog_post 			= 	BlogPost::find($id); 
    	if(request()->img_del){
    		$storage_path 	= 	storage_path(config('constants.remove_img'));
			@unlink($storage_path . '/' . $blog_post->img_name);
			$blog_post->img_name 	= 	'';
    	} 
    	if(request()->file){
    		$storage_path = storage_path(config('constants.remove_img'));
			@unlink($storage_path . '/' . $blog_post->img_name);
			$file = request()->file("file");
			$file_unique_name = 'editor' . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();

			$is = $file->storeAs(config('constants.img_folder'), $file_unique_name);
			$blog_post->img_name = $file_unique_name;
		}
    	$blog_post->title 	= 	request()->title;
    	$blog_post->type 	= 	request()->type;
    	$blog_post->status 	= 	request()->status;
    	$blog_post->summary =   request()->summary;
    	$blog_post->body 	= 	htmlspecialchars(request()->body);
    	$is_upated 			= 	$blog_post->update();
    	if($is_upated){
    		$is_deleted = $blog_post->blogPostRelation()->delete();
				if(!empty(request()->shopaholic_group)){
					foreach (request()->shopaholic_group as $key => $value) {
						$blog_shopaholic_group_relation 				= 	new BlogPostRelationship;
						$blog_shopaholic_group_relation->object_id 		= 	$value;
						$blog_shopaholic_group_relation->type      		= 	'shopaholic_group';
						$blog_shopaholic_group_relation->blog_post_id 	= 	$id;
						$blog_shopaholic_group_relation->save(); 
					}
				}
				if(!empty(request()->shopaholics)){
					foreach (request()->shopaholics as $key => $value) {
						$blog_shopaholic_relation 					= 	new BlogPostRelationship;
						$blog_shopaholic_relation->object_id 		= 	$value;
						$blog_shopaholic_relation->type      		= 	'shopaholic';
						$blog_shopaholic_relation->blog_post_id 	= 	$id;
						$blog_shopaholic_relation->save();
					}
				}
				if(!empty(request()->country)){
					foreach (request()->country as $key => $value) {
						$blog_country_relation 					= 	new BlogPostRelationship;
						$blog_country_relation->object_id 		= 	$value;
						$blog_country_relation->type      		= 	'country';
						$blog_country_relation->blog_post_id 	= 	$id;
						$blog_country_relation->save();
					}
				}  
    		$msg['status'] 	= 	1;
    		return json_encode($msg);
    	}else{
    		$msg['status'] 	= 	0;
    		return json_encode($msg);
    	}
    }

    public function delete(){
    	$id = request()->id;
    	$blog_post  = BlogPost::find($id);
    	$blog_post->blogPostShopaholic()->delete();
    	$is_deleted = $blog_post->delete();
    	if($is_deleted){
    		$msg['status'] = 1;
    		return json_encode($msg);
    	}else{
    		$msg['status'] = 0;
    		return json_encode($msg);
    	}
    }

    public function viewPost($id){
    	$blog_post = BlogPost::find($id);
    	return view('blog-post.blog-view',compact('blog_post'));
    }
}
