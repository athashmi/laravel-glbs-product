<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Employee;
use App\Country;

class AdminEmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	//$this->existingMigrationModification();

    	$this->newMigrationRun();
    	
    }


    function newMigrationRun()
    {


       
        $admins = DB::connection('mysql_old_data')->table('admins')
                        /*->where('id', '>', 17096)
                           ->limit(1)*/
                            ->get();



        $admin_owners = [
            [
                'first_name' => 'owner',
                'last_name' => 'person',
                'password' => '$2y$10$Qf5jsDBxoMttCjMnrBdYd.klaeHEZiEkhRvn85Dv2CViW9GuJYaOW', //123456
                'email' => 'owner@gmail.com',
                'created_at' => date('Y-m-d H:i:s'),
                'email_verified_at' => date('Y-m-d H:i:s'),

            ],
            [
                'first_name' => 'admin',
                'last_name' => 'person',
                'password' => '$2y$10$Qf5jsDBxoMttCjMnrBdYd.klaeHEZiEkhRvn85Dv2CViW9GuJYaOW', //123456
                'email' => 'admin@gmail.com',
                'created_at' => date('Y-m-d H:i:s'),
                'email_verified_at' => date('Y-m-d H:i:s'),            
            ]
        ];


       foreach ($admin_owners as $usr) {

            $user  = new User;
            

            $user->first_name = $usr['first_name'];
            $user->last_name = $usr['last_name'];
            $user->password = $usr['password'];
            $user->email = $usr['email'];
            $user->created_at = $usr['created_at'];
            $user->email_verified_at = $usr['email_verified_at'];
            
           $user->save();

           if($usr['first_name']=='owner'):
                $owner_role =  DB::table('roles')->where('name','owner')->first();

                $user->attachRole($owner_role->id);

           endif;

           if($usr['first_name']=='admin'):
                $admin_role =  DB::table('roles')->where('name','admin')->first();

                $user->attachRole($admin_role->id);

           endif;

        }

        

        foreach ($admins as $admin) {

            $user  = new User;
            $user->id = $admin->id;

            $user->first_name = $admin->username;
            
            $user->email = $admin->email;
            $user->password = $admin->password;
            $user->created_at = $admin->created_at;
            $user->updated_at = $admin->updated_at;

            

            if($admin->country_code):
                $ctry_id = Country::select('id')
                               ->where('iso',$admin->country_code)
                               ->first();
                if($ctry_id->id):
                    $user->country_id = $ctry_id->id;
                endif;
            endif;

            
                $user->gender = 'other';
           

            if($admin->phone):
                $user->phone = $admin->phone;
            endif;

            
                $user->email_verified_at = $admin->created_at;

                $user->save();

            if($admin->type =='admin')
            {
               $admin_role =  DB::table('roles')->where('name','admin')->first();

               $user->attachRole($admin_role->id);

            }

             if($admin->type =='level2')
            {
               $worker =  DB::table('roles')->where('name','employee')->first();

               $user->attachRole($worker->id);

               $employee = new Employee;

               $employee->user_id = $user->id;
               $employee->hire_date = $user->created_at;

               $employee->save();

            }
          
            

            

        }

    }


    function existingMigrationModification()
    {

    	$employees = User::whereHas('roles', function ($q) {
                  			$q->where('name', 'worker');
                  			$q->orWhere('name', 'employee');
                  			
                  		})->get();

		$employee_role =  DB::table('roles')->where('name','employee')->first();

		foreach ($employees as $usr) {

			$usr->attachRole($employee_role->id);

			$employee = new Employee;

               $employee->user_id = $usr->id;
               $employee->hire_date = $usr->created_at;

               $employee->save();
			
		}

		dd('done');

    }

    
}
