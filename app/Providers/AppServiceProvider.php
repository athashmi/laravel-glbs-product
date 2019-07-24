<?php

namespace App\Providers;
// use Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
          // \Blade::if('client',function()
          //   {
          //       return Auth::user()->hasRole('client');
          //   });
        date_default_timezone_set('Asia/Karachi');
          
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
