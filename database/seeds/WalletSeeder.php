<?php

use Illuminate\Database\Seeder;

use App\Shopaholic;
use App\WalletRequest;
use App\ShopaholicFailedTransaction;
use App\WalletTransaction;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

     	$this->createShopaholicWallet();
		$this->createShopaholicFailedTransactions();

    	
    }

    function createShopaholicWallet()
    {

        $wallet_recds = DB::connection('mysql_old_data')->table('wallet')
                            ->where('current_balance','!=',0.00)
                            ->get();

        foreach ($wallet_recds as $wallet_recd) {
        	
        	$shopaholic = Shopaholic::where('sn','sn-'.$wallet_recd->user_id)->first();

        	//dd($shopaholic);

        	$new_wallet_request  =  new WalletRequest;
            $new_wallet_request->amount = $wallet_recd->current_balance;
            
            $new_wallet_request->status = 'processed';
            
            if($wallet_recd->current_balance < 0)
            $new_wallet_request->type = 'offline_payment';

            if($wallet_recd->current_balance > 0)
            $new_wallet_request->type   = 'deposit';

            $new_wallet_request->processed_by = 3;
            $new_wallet_request->user_id  = $shopaholic->user_id;

            if( $wallet_recd->created_at == '0000-00-00 00:00:00')
                $new_wallet_request->created_at = $wallet_recd->updated_at;
            else
                $new_wallet_request->created_at = $wallet_recd->created_at;

            $new_wallet_request->updated_at = $wallet_recd->updated_at;

            $new_wallet_request->save();


            $new_wallet_transec = new WalletTransaction;

            $new_wallet_transec->opening_balance = 0;

            $new_wallet_transec->closing_balance = $wallet_recd->current_balance;

            $new_wallet_transec->request_id = $new_wallet_request->id;

            $new_wallet_transec->save();

        }
     	/*DB::connection('mysql_old_data')->table('track_wallet')
        ->where('shopaholic_id',$shopaholic->id)
        ->update(
                ['shopaholic_id' => $this->new_shopaholic->id]
            );
        endif;*/
    }

   function createShopaholicFailedTransactions(){

        $transections = DB::connection('mysql_old_data')->table('failed_transactions')
                            //->where('userID',$old_id)
                            ->get();

         foreach ($transections as $transection) {
         	$shopaholic = Shopaholic::where('sn','sn-'.$transection->userID)->first();

         	$new_trns = new ShopaholicFailedTransaction;
            $new_trns->error_msg = $transection->errorMessage;
            $new_trns->error_code = $transection->errorCode;
            $new_trns->payment_gateway = $transection->paymentGateway;
            $new_trns->shopaholic_id = $shopaholic->id;
            $new_trns->created_at = $transection->created_at;
            $new_trns->updated_at = $transection->updated_at;

            $new_trns->save();
         	
         }
        
    }
}
