<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Country;
use App\Shopaholic;
use App\ShopaholicAddress;
use App\ShopaholicsInfo;
use App\WarehouseShelf;
use App\ShopaholicCreditInfo;
use App\ShopaholicFailedTransaction;

use App\WalletTransaction;
use App\WalletRequest;

class ShopaholicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $user ;
    private $new_shopaholic;



    public function run()
    {
        
        $this->insertShopaholics();

        $this->testShopaholicData();
    }

   
    function insertShopaholics()
    {
    	$shopaholics = DB::connection('mysql_old_data')->table('shopaholics')
                          /*->where('id', '>', 17096)
                           ->limit(1)*/
                            ->get();

    	//dd($shopaholics);

    	foreach ($shopaholics as $shopaholic) {
    		
    		
            $this->createUser($shopaholic);
            
    	}

        echo "Shopaholics : Done";
    }


    function createUser($shopaholic){

        $user  = new User;

        if($shopaholic->first_name !='' && $shopaholic->email !=''):
            //$user->id = $shopaholic->id;

            /*if(strlen($shopaholic->first_name) > 40){
                $user->first_name =  substr($shopaholic->first_name,0,30);
                //dd($user->first_name.'kkkk');
            }
            else
            {*/
                //dd('lll');
            $user->first_name = $shopaholic->first_name;
            //}

            $user->last_name    =   $shopaholic->last_name;
            $user->email        =   $shopaholic->email;
            $user->password     =   $shopaholic->password;
            $user->created_at   =   $shopaholic->created_at;
            $user->updated_at   =   $shopaholic->updated_at;

            

            if($shopaholic->country_code):
                $ctry_id = Country::select('id')
                               ->where('iso',$shopaholic->country_code)
                               ->first();
                if($ctry_id->id):
                    $user->country_id = $ctry_id->id;
                endif;
            endif;

            if($shopaholic->gender == 'Male'):
                $user->gender = 'male';
            elseif($shopaholic->gender == 'Female'):
                $user->gender = 'female';
            else:
                $user->gender = 'other';
            endif;


            if($shopaholic->picture):
                $found = strrpos($shopaholic->picture, 'picture?');
            //dd($found);
                if(!$found):
                    //dd('hhhh---'.$shopaholic->picture);
                   
                    $img_path = 'https://globalshopaholics.com/';
                    //assets/images/profile_pic/';
                    $img = $img_path.$shopaholic->picture;
                   // dd($img);


                    $file_name = basename($img);
                    $file_path = storage_path().'/'.config('constants.img_folder').'/';

                    if (\File::copy($img , $file_path.$file_name)) {
                          $user->picture = $file_name;               
                    }
                endif;
              
            endif;
            

            if($shopaholic->dob):
                $user->dob = date('Y-m-d',strtotime($shopaholic->dob));
            endif;

            if($shopaholic->phone):
                $user->phone = $shopaholic->phone;
            endif;

            if($shopaholic->is_email_verified):
                $user->email_verified_at = $shopaholic->created_at;
            endif;



              

            $user->save();

             $shopaholic_role =  DB::table('roles')->where('name','shopaholic')->first();

               $user->attachRole($shopaholic_role->id);

            $this->user = $user;




            $this->createShopaholic($shopaholic);

            $this->createAddresses($shopaholic);

            $this->createShopaholicInfo($shopaholic);

            $this->createShopaholicCreditInfo($shopaholic);

           
        endif;
    }

    function createShopaholic($shopaholic){


            //populate shopaholic table
            $new_shopaholic = new Shopaholic;

            if($shopaholic->is_corporate)
                $new_shopaholic->type = 'corporate';
            else
               $new_shopaholic->type = 'ordinary'; 

           if($shopaholic->reserved_warehouse_location !=0):
                $w_shelf_loc_id = WarehouseShelf::where('name',$shopaholic->reserved_warehouse_location)->first();
                if($w_shelf_loc_id):
                    $new_shopaholic->reserved_warehouse_shelf_id = $w_shelf_loc_id->id;
                endif;


            endif;

            $new_shopaholic->sn = 'sn-'.$shopaholic->id;



            $new_shopaholic->created_at   =   $shopaholic->created_at;
            $new_shopaholic->updated_at   =   $shopaholic->updated_at;

           $new_shopaholic->user_id = $this->user->id;

           if($shopaholic->deleted_at):
                $new_shopaholic->deleted_at = $shopaholic->deleted_at;
            endif;

            if($shopaholic->is_corporate)
                $new_shopaholic->type = 'corporate';
            else
                $new_shopaholic->type = 'ordinary';

           $new_shopaholic->save();

           $this->new_shopaholic = $new_shopaholic;
    }

    function createAddresses($shopaholic){

        //primary address
           
            /*if($primary_address):
                if($primary_address->city =='' && $primary_address->state =='' && $primary_address->street =='' && $primary_address->zip =='')
                    $new_shopaholic->address = NULL;
                else
                $address['city']     =   $primary_address->city;
                $address['state']    =   $primary_address->state;
                $address['street']   =   $primary_address->street;
                $address['zip_code'] =   $primary_address->zip;

                $new_shopaholic->address = $address;
           endif;*/
        
           //populate shpaholic_addresses table

           $addresses = DB::connection('mysql_old_data')->table('user_address')
                                //->where('isPrimary',0)
                                ->where('user_id',$shopaholic->id)
                                ->get();

            if($addresses):
                foreach ($addresses as $address) {


                    if( $address->city !='' && ($address->state !='') && ($address->street !='') && ($address->zip !='')):

                    $new_address = new ShopaholicAddress;

                    if($address->isPrimary == 1):
                        /*dd($address);*/
                        $new_address->type ='primary';
               
                    endif;

                    

                    if($address->receiver_name)
                        $new_address->name = $address->receiver_name;
                    else
                        $new_address->name = $shopaholic->first_name.' '.$shopaholic->last_name;

                    if($address->country_code):
                        $ctry_id = Country::select('id')
                               ->where('iso',$address->country_code)
                               ->first();
                        if($ctry_id)
                            $new_address->country_id = $ctry_id->id;

                    endif;
                    $new_address->phone = $address->phone;
                    $new_address->street = $address->street;
                    $new_address->city = $address->city;

                    $new_address->state = $address->state;
                    $new_address->zip_code = $address->zip;
                    $new_address->shopaholic_id = $this->new_shopaholic->id;

                    $new_address->save();
                endif;
                }

            endif; 
    }

    function createShopaholicInfo($shopaholic)
    {

         //populate shopaholics_infos table

            if($shopaholic->ip_address):
                $new_shopaholic_info = new ShopaholicsInfo;

                $new_shopaholic_info->shopaholic_id = $this->new_shopaholic->id;
                $new_shopaholic_info->ip_address = $shopaholic->ip_address;

                $new_shopaholic_info->save();
            endif;
    }

    function createShopaholicCreditInfo($shopaholic)
    {

        //populate shopaholic_credit_infos
                 $credit_cards = DB::connection('mysql_old_data')->table('credit_card_info')
                                ->where('userID',$shopaholic->id)
                                ->get();
                if($credit_cards):
                    foreach ($credit_cards as $credit_card) {

                        $new_card = new ShopaholicCreditInfo;

                        if($credit_card->firstTranAmount == '')
                            $new_card->first_transec_amount = 0.00;
                        else
                            $new_card->first_transec_amount = $credit_card->firstTranAmount;
                        if($credit_card->secondTranAmount == '')
                            $new_card->second_transec_amount = 0.00;
                        else
                            $new_card->second_transec_amount = $credit_card->secondTranAmount;
                        $new_card->digit = $credit_card->cardLastFourDigit;
                        $new_card->attempt = $credit_card->attemptCount;
                        $new_card->created_at = $credit_card->created_at;
                        $new_card->updated_at = $credit_card->updated_at;

                        if($credit_card->isVerified)
                            $new_card->status = 'verified';

                        if($credit_card->isCancelled==1)
                          $new_card->deleted_at = $credit_card->updated_at; 
                          
                        if($credit_card->isCancelled==2)
                          $new_card->status = 'blocked';

                      $new_card->shopaholic_id = $this->new_shopaholic->id;

                      $new_card->save();

                    }
                endif;
    }

   
    


    function testShopaholicData()
    {

        $last_rec = Shopaholic::orderBy('created_at', 'desc')->first();

        $id_arr  = explode('-',$last_rec->sn);

        $id = $id_arr[1];

       // dd($id_arr);

        $request_arr =[];
        $user = 
            [
                'id'=> ++$id,
                'first_name' => 'Adnan',
                'last_name' => 'tahir',
                'password' => '$2y$10$Qf5jsDBxoMttCjMnrBdYd.klaeHEZiEkhRvn85Dv2CViW9GuJYaOW', //123456
                'email' => 'adnanhashmi.gs@gmail.com',
                'gender' =>'male',
                'country_id'=> 162,
                'dob'=> date('Y-m-d'),
                'phone'=> 4234324324,
                'account_type'=> 'regular',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'email_verified_at' => date('Y-m-d H:i:s'),
        ];

        $user_obj = User::create($user);



        $shopaholic = [

                'user_id' => $user_obj->id,
                'type' => 'corporate',
                'sn' => 'sn-'.$user_obj->id, //123456
                
                

        ];

              $shopaholic_obj = Shopaholic::create($shopaholic);

              $shopaholic_role =  DB::table('roles')->where('name','shopaholic')->first();

              $user_obj->attachRole($shopaholic_role->id);

              $addresses = [
                                [
                                    'name'  => 'Adnan Hashmi',
                                    "city"=> "Islamabad", 
                                    "state"=> "Fedral", 
                                    'phone' => 12345678,
                                    "street"=> "house # 170-A, street # 70", 
                                    "zip_code"=> "44000",
                                    'type' => 'primary',
                                    'country_id'=>162,
                                    'shopaholic_id'=> $shopaholic_obj->id

                                ],
                                [

                                    'name'  => 'Adnan Hashmi',
                                    'phone' => 12345678,
                                    'street'=>'Flate # 2 Naseem Plaza Shamasabad', 
                                    'city'=>'Rawalpindi',
                                    'state'=>'Punjab',
                                    'zip_code'=>'44000',
                                    'country_id'=>162,
                                    'shopaholic_id'=> $shopaholic_obj->id
                                ],
                                [

                                    'name'  => 'Adnan Tahir',
                                    'phone' => 12345678,
                                    'street'=>'house # 126, main neelam road, G-9/3', 
                                    'city'=>'Islamabad',
                                    'state'=>'Fedral territory',
                                    'zip_code'=>'44000',
                                    'country_id'=>162,
                                    'shopaholic_id'=> $shopaholic_obj->id

                                ],
                                [


                                    'name'  => 'Adnan Hashmi',
                                    'phone' => 12345678,
                                    'street'=>'House # 12, Street # 1, G-6/1', 
                                    'city'=>'Islamabad',
                                    'state'=>'Fedral territory',
                                    'zip_code'=>'44000',
                                    'country_id'=>162,
                                    'shopaholic_id'=> $shopaholic_obj->id
                                ]
                            ];

                foreach ($addresses as $s_address) {
                    
                    $new_address = new ShopaholicAddress;

                    if(isset($s_address['type']))
                        $new_address->type = $s_address['type'];
                    
                        $new_address->name = $s_address['name'];

                    
                        $new_address->country_id = $s_address['country_id'];

                   
                    $new_address->phone = $s_address['phone'];
                    $new_address->street = $s_address['street'];
                    $new_address->city = $s_address['city'];

                    $new_address->state = $s_address['state'];
                    $new_address->zip_code = $s_address['zip_code'];
                    $new_address->shopaholic_id = $s_address['shopaholic_id'];

                    $new_address->save();
                }



                $credit_card = [
                                    'first_transec_amount' => '0.30',
                                    'second_transec_amount' => '0.20',
                                    'digit' => '8888',
                                    'status' => 'verified',
                                    'type'   => 'visa',
                                    'shopaholic_id' => $shopaholic_obj->id,
                                    'verified_by' => '1',
                                    'verified_through' => 'manual',
                                    'created_at' => date('Y-m-d H:m:s'),
                                    'updated_at' => date('Y-m-d H:m:s'),
                                ];


       
            ShopaholicCreditInfo::create($credit_card);


            $deposits = [
            [
                'amount' => '20.00',
                'status' => 'processed',
                'type' => 'deposit',
                'details' => ["deposit" => ["process_via" => "authorize_net", "transactionID" => "40025996713", "credit_card_last_digit" => "8888"], "child_request_id" => "0"],
                'user_id' => $user_obj->id,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],

            [
                'amount' => '30.00',
                'status' => 'processed',
                'type' => 'deposit',
                'details' => ["deposit" => ["process_via" => "authorize_net", "transactionID" => "40025996730", "credit_card_last_digit" => "8888"], "child_request_id" => "0"],
                'user_id' => $user_obj->id,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            [
                'amount' => '60.00',
                'status' => 'processed',
                'type' => 'deposit',
                'details' => ["deposit" => ["process_via" => "authorize_net", "transactionID" => "40025996735", "credit_card_last_digit" => "8888"], "child_request_id" => "0"],
                'user_id' => $user_obj->id,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            
            [
                'amount' => '38.24',
                'status' => 'processed',
                'type' => 'deposit',
                'details' => ["deposit" => ["payerID" => "JD7LWZZK9FJBN", "paymentID" => "PAYID-LR37NUY70H79420V35189743", "process_via" => "paypal"], "child_request_id" => "0"],
                'user_id' => $user_obj->id,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            [
                'amount' => '70.00',
                'status' => 'processed',
                'type' => 'deposit',
                'details' => ["deposit" => ["process_via" => "authorize_net", "transactionID" => "40025996894", "credit_card_last_digit" => "8888"], "child_request_id" => "0"],
                'user_id' => $user_obj->id,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            [
                'amount' => '40.00',
                'status' => 'processed',
                'type' => 'deposit',
                'details' => ["deposit" => ["process_via" => "authorize_net", "transactionID" => "40025996910", "credit_card_last_digit" => "8888"], "child_request_id" => "0"],
                'user_id' => $user_obj->id,
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
        ];


        $refunded[] =[
                        'deposit'=>[
                                    'amount' => '19.12',
                                    'status' => 'processed',
                                    'type' => 'deposit',
                                    'details' => ["deposit" => ["payerID" => "JD7LWZZK9FJBN", "paymentID" => "PAYID-LR37LUI6AJ15798AH835592N", "process_via" => "paypal"], "child_request_id" => "0"],
                                    'user_id' => $user_obj->id,
                                    'created_at' => date('Y-m-d H:m:s'),
                                    'updated_at' => date('Y-m-d H:m:s'),
                                    ],
                        'refunded'=>[
                                    'amount' => '19.12',
                                    'status' => 'processed',
                                    'type' => 'refunded',
                                    'user_id' => $user_obj->id,
                                    'created_at' => date('Y-m-d H:m:s'),
                                    'updated_at' => date('Y-m-d H:m:s')
                                    ]
                    ];
        
            foreach ($deposits as $key => $value) {
            //dd($value['details']);
            $request_obj = new WalletRequest;
            $request_obj->amount = $value['amount'];
            $request_obj->status  = $value['status'];
            $request_obj->type = $value['type'];
            $request_obj->details  = $value['details'];
            $request_obj->user_id = $value['user_id'];
            $request_obj->save();
            sleep(1);
            $request_arr[] = $request_obj->id;
        }


        foreach ($refunded as $key => $value) {
            if($value['deposit']){
                $request_r_obj = new WalletRequest;
                $request_r_obj->amount = $value['deposit']['amount'];
                $request_r_obj->status  = $value['deposit']['status'];
                $request_r_obj->type = $value['deposit']['type'];
                $request_r_obj->details  = $value['deposit']['details'];
                $request_r_obj->user_id = $value['deposit']['user_id'];
                $request_r_obj->save();
                sleep(1);
                $parent_id = $request_r_obj->id;
                $request_arr[] = $parent_id;
            }
            if($value['refunded']){
                $request_w_obj = new WalletRequest;
                $request_w_obj->amount = $value['refunded']['amount'];
                $request_w_obj->status = $value['refunded']['status'];
                $request_w_obj->type = $value['refunded']['type'];
                $request_w_obj->details  = ["refunded" => [
                                                        "process_via" => "paypal",
                                                        "transactionId" => "7GX449308D523621C",
                                                        "parent_wallet_request_id" => $parent_id,
                                                        ]
                                                ];
                $request_w_obj->user_id = $value['refunded']['user_id'];
                $request_w_obj->save();
                sleep(1);
                $request_arr[] = $request_w_obj->id;
                $wa_re = WalletRequest::find($parent_id);
                $wa_re->details = ["deposit" => ["payerID" => "JD7LWZZK9FJBN", "paymentID" => "PAYID-LR37LUI6AJ15798AH835592N", "process_via" => "paypal"], "child_request_id" => $request_w_obj->id];
                $wa_re->update();
            }
        }


        $wallet_transaction = [
            [
                'opening_balance' => '0.00',
                'closing_balance' => '20.00',
                'request_id' => $request_arr[0],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            [
                'opening_balance' => '20.00',
                'closing_balance' => '50.00',
                'request_id' => $request_arr[1],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            [
                'opening_balance' => '50.00',
                'closing_balance' => '110.00',
                'request_id' => $request_arr[2],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            [
                'opening_balance' => '110.00',

                'closing_balance' => '148.24',

                'request_id' => $request_arr[3],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            [
    'opening_balance' => '148.24',
                'closing_balance' => '218.24',

                'request_id' => $request_arr[4],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            [

                'opening_balance' => '218.24',
                'closing_balance' => '258.24',

                'request_id' => $request_arr[5],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            [

                'opening_balance' => '258.24',

                'closing_balance' => '277.36',
                'request_id' => $request_arr[6],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],
            [

                'opening_balance' => '277.36',

                'closing_balance' => '258.24',
                'request_id' => $request_arr[7],
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s'),
            ],

        ];
        foreach ($wallet_transaction as $key => $value) {
            WalletTransaction::create($value);
        }

    }


}
