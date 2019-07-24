<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Shopaholic;
use App\Option;
use App\Role;
use URL;
use Socialite;
use Exception;
use Config;
use Auth;
use DateTime;
class AuthSocialLoginController extends Controller
{

    public function __construct(){
        
        /******** Config set for Facebook *****/

         Config::set('services.facebook.client_id', $this->socialite_config('facebook_api','client_id') );
         Config::set('services.facebook.client_secret', $this->socialite_config('facebook_api','client_secret') );
         Config::set('services.facebook.redirect', URL::to("/").'/'.$this->socialite_config('facebook_api','client_callback_url') );

        /******** Config set for Twitter *****/

         Config::set('services.twitter.client_id', $this->socialite_config('twitter_api','client_id') );
         Config::set('services.twitter.client_secret', $this->socialite_config('twitter_api','client_secret') );
         Config::set('services.twitter.redirect', URL::to("/").'/'.$this->socialite_config('twitter_api','client_callback_url') );

         /******** Config set for Google *****/

         Config::set('services.google.client_id', $this->socialite_config('googleplus_api','client_id') );
         Config::set('services.google.client_secret', $this->socialite_config('googleplus_api','client_secret') );
         Config::set('services.google.redirect', URL::to("/").'/'.$this->socialite_config('googleplus_api','client_callback_url') );
    }
    private function socialite_config($name,$returnType){
        $option = Option::where([
            ['module', '=', $name],
            ['key', '=', $returnType]
        ])->first();
        if($option)
        {
            return $option->value;
        }
    }
    public function redirectToFacebook() {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(){
        try {

                $user       = Socialite::driver('facebook')->user();
                $user_check = User::where('social_login_id',$user->getId())->first();
                if($user_check) {
                    Auth::loginUsingId($user_check->id);
                    return redirect()->route('client_dashboard');
                }
                else{
                    $facebook_img_link  = file_get_contents($user->avatar_original);
                    $file_name          = $user->getName(). '-' . time() . '-' . date("Ymdhis") . rand(0, 999).'.'.'jpg';
                    try {
                            file_put_contents(storage_path().'/'.config('constants.img_folder').'/'.$file_name, $facebook_img_link);
                        } catch (Exception $e) {
                            echo 'Caught exception: ',  $e->getMessage(), "\n";
                        }  

                    $user_obj                       =   new User();
                    $user_obj->first_name           =   $user->getName();
                    $user_obj->email                =   $user->getEmail();
                    $user_obj->social_login_id      =   $user->getId();
                    $user_obj->account_type         =   'facebook';
                    $dt                             =   new DateTime;
                    $user_obj->email_verified_at    = $dt->format('Y-m-d H:i:s');
                    $user_obj->picture              =   $file_name;
                    $is_saved                       =   $user_obj->save();

                    $role                           =   Role::where('name','shopaholic')->first();
                    $user_obj->roles()->attach($role->id);
                    $shopaholic_obj                 =   new Shopaholic();
                    $shopaholic_obj->user_id        =   $user_obj->id;
                    $shopaholic_obj->type           =   'ordinary';
                    $shopaholic_obj->sn             =   'sn-'.$user_obj->id;
                    $shopaholic_obj->save();
                    Auth::loginUsingId($user_obj->id);
                    return redirect()->route('client_dashboard');
                }

            
        } catch (Exception $e) {
            return redirect('auth/facebook');
        }
    }

    public function redirectToTwitter(){
        return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterCallback(){
        try {
                $user       = Socialite::driver('twitter')->user();
                $user_check = User::where('social_login_id',$user->getId())->first();
                if($user_check){
                    Auth::loginUsingId($user_check->id);
                    return redirect()->route('client_dashboard');
                }
                else {
                    $twitter_img_link   = file_get_contents($user->avatar_original);
                    $file_name          = $user->getName(). '-' . time() . '-' . date("Ymdhis") . rand(0, 999).'.'.'jpg';
                    try {
                            file_put_contents(storage_path().'/'.config('constants.img_folder').'/'.$file_name, $twitter_img_link);
                        } catch (Exception $e) {
                            echo 'Caught exception: ',  $e->getMessage(), "\n";
                        }           

                    $user_obj                       =   new User();
                    $user_obj->first_name           =   $user->getName();
                    $user_obj->email                =   $user->getEmail();
                    $user_obj->social_login_id      =   $user->getId();
                    $user_obj->account_type         =   'twitter';
                    $user_obj->picture              =   $file_name;
                    $dt                             =   new DateTime;
                    $user_obj->email_verified_at    = $dt->format('Y-m-d H:i:s');
                    $is_saved                       =   $user_obj->save();
                    $role                           =   Role::where('name','client')->first();
                    $user_obj->roles()->attach($role->id);
                    $shopaholic_obj                 =   new Shopaholic();
                    $shopaholic_obj->user_id        =   $user_obj->id;
                    $shopaholic_obj->type           =   'ordinary';
                    $shopaholic_obj->sn             =   'sn-'.$user_obj->id;
                    $shopaholic_obj->save();
                    Auth::loginUsingId($user_obj->id);
                    return redirect()->route('client_dashboard');
                }
            
        } catch (Exception $e) {
            return redirect('auth/twitter');
        }
    }

    public function redirectToGoolePlus(){
        return Socialite::driver('google')->redirect();
    }


    public function handleGoolePlusCallback(){
        try {
                $user       = Socialite::driver('google')->user();
                $user_check = User::where('social_login_id',$user->getId())->first();
                if($user_check){
                    Auth::loginUsingId($user_check->id);
                    return redirect()->route('client_dashboard');
                }
                else{
                    $google_plus_img_link   = file_get_contents($user->avatar_original);
                    $file_name              = $user->getName(). '-' . time() . '-' . date("Ymdhis") . rand(0, 999).'.'.'jpg';
                    try {
                            file_put_contents(storage_path().'/'.config('constants.img_folder').'/'.$file_name, $google_plus_img_link);
                        } catch (Exception $e) {
                            echo 'Caught exception: ',  $e->getMessage(), "\n";
                        }
                    $user_obj                       =   new User();
                    $user_obj->first_name           =   $user->getName();
                    $user_obj->email                =   $user->getEmail();
                    $user_obj->social_login_id      =   $user->getId();
                    $user_obj->account_type         =   'google plus';
                    $user_obj->picture              =   $file_name;
                    $dt                             = new DateTime;
                    $user_obj->email_verified_at    = $dt->format('Y-m-d H:i:s');
                    $is_saved                       =   $user_obj->save();
                    $role                           =   Role::where('name','shopaholic')->first();
                    $user_obj->roles()->attach($role->id);
                    $shopaholic_obj                 =   new Shopaholic();
                    $shopaholic_obj->user_id        =   $user_obj->id;
                    $shopaholic_obj->type           =   'ordinary';
                    $shopaholic_obj->sn             =   'sn-'.$user_obj->id;
                    $shopaholic_obj->save();
                    Auth::loginUsingId($user_obj->id);
                    return redirect()->route('client_dashboard');
                }

            
        } catch (Exception $e) {
            return redirect('auth/googleplus');
        }
    }
}
