<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class ShoaholicsPicturesImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gs_picture:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import pictures from old project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::where('picture','!=',NULL)->get();

        //dd($users->count());
        foreach($users as $user)
        {
            
            $found = strrpos($user->picture, 'picture?');
//dd($found);
            if($found !==0):
                //var_dump(strrpos($user->picture, 'picture?').'---'.$user->picture);
                $img_path = '/var/www/html/gs-live/assets/images/profile_pic/';
                $img = $img_path.$user->picture;
               // dd($img);


                $file_name = basename($img);
                $file_path = storage_path().'/'.config('constants.img_folder').'/';

                if (\File::copy($img , $file_path.$file_name)) {
                    //file_put_contents(storage_path().'/'.config('constants.img_folder').'/'.$file_name, $img);
                    User::where('id', $user->id)
                    ->update(['picture' => $file_name]);
                   // dd('lll');
                }
            endif;

            ///var/www/html/gs-live/assests/images/profile_pic/20160421173444.png
            ///var/www/html/gs-live/assets/images/profile_pic/20160421173444.png

        }
    }
}
