<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Docs;
use DataTables;

class DocsController extends Controller
{

  public function index() {

  $docs = Docs::all();
  return view('docs.developers.list',compact('docs',$docs));
}

public function getdocs(){
$docs 	= Docs::select('*');
return DataTables::of($docs)
  ->editColumn('title', function ($docs) {
    return $docs->title;
  })
  ->editColumn('type', function ($docs) {
      return $docs->type;
  })
  ->editColumn('category', function ($docs) {
    return $docs->category;
  })
  ->editColumn('description', function ($docs) {
    return $docs->description;
  })
  ->addColumn('action', function ($docs) {
    return view('docs.developers.action-buttons', ['result' => $docs])->render();
  })->make(true);
}


public function create(){
  $docs = Docs::all();
  return view('docs.developers.add-doc',compact('docs'));
}

public function store(Request $request){
//dd($request->all());
$request->validate([
  'title'=>'required',
  'type'=>'required',
  'category'=>'required',
  'description'=>'required',
]);
$doc = new Docs();
$doc->title = request()->title;
$doc->type = request()->type;
$doc->category  = request()->category;
$doc->description = request()->description;
$is_saved = $doc->save();

if($is_saved){
  $msg['status'] 	= 	1;
  return json_encode($msg);
}else{
  $msg['status'] 	= 	0;
  return json_encode($msg);
}

}


public function edit($id){
  $docs = Docs::where('id',$id)->first();
  return view('docs.developers.edit-doc',compact('docs'));
}


public function update(Request $request){


  $request->validate([
  'title' 		=> 	'required',
  'type' 			=> 	'required',
  'category' =>   'required',
  'description'       =>  'required',
]);
  $id 				= 	request()->id;
  $docs		= 	Docs::find($id);

  $docs->title 	= 	request()->title;
  $docs->type 	= 	request()->type;
  $docs->category 	= 	request()->category;
  $docs->description =   request()->description;
  $is_updated= $docs->update();

if($is_updated){
    $msg['status'] 	= 	1;
    return json_encode($msg);
  }else{
    $msg['status'] 	= 	0;
    return json_encode($msg);
  }

}

}
