<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Carbon\Carbon;
use View;
use App\EmployeeAttandence;

use JavaScript;



class EmployeeController extends Controller
{
	protected $employee_id;

	protected $remaining_time;

	protected $day_start;
    protected $refuse_login = false;

    

    function __construct()
    {
    	 $this->middleware(function ($request, $next) {

	    	$this->employee_id = Auth::user()->employee->id;
	    	$this->remainingTime();


	        return $next($request);
	    });  
    }



    function remainingTime()
    {
    	//dd($this->employee_id);
    	 $daystart = EmployeeAttandence::where('employee_id',$this->employee_id)
                                        ->whereRaw('DATE(started_at) = CURDATE()')
                                        //->where('ended_at', NULL)
                                        ->first();



        if(!$daystart):
            $daystart = new EmployeeAttandence();
            $daystart->started_at = Carbon::now();
            $daystart->employee_id = $this->employee_id;
            $daystart->save();
        endif;
        //dd( $daystart);
        $start_time     = Carbon::parse($daystart->started_at);
        $time_now      	= Carbon::now();
       // dd($start_time );
        $duration  		= $time_now->diffInSeconds($start_time);

        //dd($duration);
        $totalWorkDayInSecs = 28800;  //8 hours = 8x60x60

        $remainingTimeInSecs = $totalWorkDayInSecs-$duration;
        //dd($remainingTimeInSecs);

        //if workday already ended or time calculation is geater then 8 hours
        if( ($daystart->ended_at!=NULL) || ($remainingTimeInSecs < 0))
        {
            $this->refuse_login = true;
        }
        //$this->remaining_time = gmdate("H:i:s", $remainingTimeInSecs);
        $this->remaining_time =  $remainingTimeInSecs;

        $this->day_start = $daystart;

        $workDayStarted = strtoupper(Carbon::parse($daystart->started_at)->format('h:i:s a'));
        //Carbon::createFromFormat('Y-m-d H:i:s.u', '2019-02-01 03:45:27.612584')
		//$time = $date->format('h:m:s a');
		

       // View::share('remaining_time',$this->remaining_time);
        View::share('work_day_started',$workDayStarted);



        JavaScript::put([
            'remaining_time' => $this->remaining_time,
            'asset_audio_url' => asset('audio')
        ]);


       
    }
}
