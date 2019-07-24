<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentMethod;
use DataTables,URL,JavaScript;

class PaymentMethodController extends Controller
{
    public function index(){
        JavaScript::put([
            'del_url' => route('payment.delete'),
        ]);
    	return view('payment-method.index');
    }
    public function getPaymentMethods(){
    	$payment_methods = PaymentMethod::all();
    	return DataTables::of($payment_methods)
    	->editColumn('image_name',function($payment_method){
    		$img = URL::route("img_file", $payment_method->image_name);
    		return '<img src="'.$img.'" class="img-fluid" />';
    	})
    	->editColumn('status',function($payment_method){
    		if($payment_method->status == 'active'){
    			return '<label class="label label-success">Active</label>';
    		}elseif($payment_method->status == 'in_active'){
    			return '<label class="label label-danger">InActive</label>';
    		}
    	})
		->rawColumns(['status', 'action', 'image_name'])
		->addColumn('action', function ($payment_method) {
			return view('payment-method.action-button', ['result' => $payment_method, 'modal_id' => 'edit_payment_model'])->render();
		})->make(true);
    }
    public function store(){
    	$validatedData 			= 	request()->validate([
			'name' 				=> 	'required',
			'charges'			=>	'required',
			'applicable_module' =>  'required', 
			'charges_type' 		=>  'required',
			'status' 			=>  'required',
			'image_name'        =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
		]);
		$msg = [];
		$payment_method = new PaymentMethod();
		$payment_method->name = request()->name;
		$key = str_replace(" ","_" , request()->name);
		$payment_method->key = strtolower($key);
		$payment_method->charges = request()->charges;
		$payment_method->applicable_module = request()->applicable_module;
		$payment_method->charges_type = request()->charges_type;
		$payment_method->status = request()->status;
		$file = request()->file("image_name");
		$file_unique_name = request()->name . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
		$payment_method->image_name = $file_unique_name;
		$file->storeAs(config('constants.img_folder'), $file_unique_name);
		$is_saved = $payment_method->save();
		if($is_saved){
			$msg['status'] = 1;
		}else{
			$msg['status'] = 0;
		}
		return response()->json($msg);
    }
    public function updateStatus(){
    	$id = request()->id;
    	$msg = [];
    	if($id){
    		$payment_method = PaymentMethod::where('id',$id)->first();
    		if($payment_method){
    			$payment_method->status = request()->status;
    			$is_updated = $payment_method->update();
    			if($is_updated){
    				$msg['status'] = 1;
    			}else{
    				$msg['status'] = 0;
    			}
    		}else{
    			$msg['status'] = 0;
    		}
    	}else{
    		$msg['status'] = 0;
    	}
    	return response()->json($msg);
    }
    public function edit(){
    	$id = request()->id;
        $msg = [];
        if($id){
            $payment_method = PaymentMethod::where('id',request()->id)->first();
            if($payment_method){
                $msg['status'] = 1;
                $msg['img_url']    = URL::route("img_file", $payment_method->image_name);
                $msg['data'] = $payment_method;
            }else{
                $msg['status'] = 0;
            }
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }
    public function update(){
        $msg = [];
        $validatedData          =   request()->validate([
            'name'              =>  'required',
            'charges'           =>  'required',
            'applicable_module' =>  'required', 
            'charges_type'      =>  'required',
            'status'            =>  'required',
            //'image_name'        =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if(request()->img_del == 1){
           $validatedData          =   request()->validate([
                'image_name'        =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
           ]); 
        }
        $payment_method = PaymentMethod::where('id',request()->id)->first();
        $payment_method->name = request()->name;
        $key = str_replace(" ","_" , request()->name);
        $payment_method->key = strtolower($key);
        $payment_method->charges = request()->charges;
        $payment_method->applicable_module = request()->applicable_module;
        $payment_method->charges_type = request()->charges_type;
        $payment_method->status = request()->status;
        if(request()->img_del == 1 || !empty(request()->file("image_name"))){
            $file = request()->file("image_name");
            $file_unique_name = request()->name . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . '.' . $file->guessExtension();
            $payment_method->image_name = $file_unique_name;
            $file->storeAs(config('constants.img_folder'), $file_unique_name);
        }
        $is_updated = $payment_method->update();
        if($is_updated){
            $msg['status'] = 1;
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }
    public function delete(){
        $msg = [];
        $id = request()->id;
        if($id){
            $payment_method = PaymentMethod::where('id',$id)->first();
            $is_deleted = $payment_method->delete();
            if($is_deleted){
                $msg['status'] = 1;
            }else{
                $msg['status'] = 0;
            }
        }else{
            $msg['status'] = 0;
        }
        return response()->json($msg);
    }
}
