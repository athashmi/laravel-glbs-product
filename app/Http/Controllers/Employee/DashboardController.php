<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmployeeAttandence;
use App\Task;
use App\TaskDetail;
use Carbon\Carbon;
use Auth,Session;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class DashboardController extends EmployeeController
{

    // a trait functions usage with other name
    use AuthenticatesUsers {
        logout as  logoutParent;
    }


	protected $msg = [];
    function index(){

        // if seconds are in minus, i.e its more then 8 hours
        if($this->refuse_login)
        {
            /*Session::put('work_day_completed','You have already completed 8 hours work today.');
            Session::flush();*/
            return $this->logoutParent(request());
        }

    	$tasks = Task::all();
        $daystart = $this->day_start;

        if(!session()->has('sort_shelves'))
        {
            //dd('kkk');
            $sorted_shelves = $this->sortShelves();
            session()->put('sort_shelves',$sorted_shelves);
        }



    	return view('employee.dashboard',compact('tasks','daystart'));
    }

    function sortShelves(){
           $count = 0;
           $order = [];
           $rows = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K');
           foreach ($rows as $key => $row) {
                for ($i=1; $i < 21; $i++) {
                    for ($k=1; $k < 21; $k++) {
                        $count++;
                        $order[$i.$row.$k] = $count;
                    }
                }
           }
           return $order;
    }
    public function upload(){
    	$time      = request()->time;
    	$task_type = request()->task_type;
    	$diffculty = request()->data;
    	$date_time = gmdate("H:i:s", $time);
    	$task_id   = '';

    	if($task_type){
    		$task = Task::where('title',$task_type)->first();
    		$task_id = $task->id;
    	}
    	$current                   = Carbon::now();
    	$task_detail               = new TaskDetail();
    	$task_detail->ended_at     = Carbon::now();
    	$task_detail->end_status   = 'task_ended';
    	$task_detail->task_id      = $task_id;
    	$task_detail->employee_id  = $this->employee_id;
    	$task_detail->details      = ['difficult' => $diffculty];
    	$started_time              = $current->subSeconds($time);
    	$task_detail->started_at   = $started_time;
    	$is_saved                  = $task_detail->save();
    	if($is_saved){
    		$this->msg['status'] = 1;
    	}else{
    		$this->msg['status'] = 0;
    	}
    	return response()->json($this->msg);
    }
    /************ Support , CleanUp , Bathroom three functionality control in same methohd ******/
    public function taskGeneral(){
        $time       = request()->time;
        $task_type  = request()->task_type;
        $task_id    = '';

        if($task_type){
            $task       = Task::where('title',$task_type)->first();
            $task_id    = $task->id;
        }
        if($task_id == ''){
            $this->msg['status'] = 0;
        }else{
            $current                    = Carbon::now();
            $task_detail                = new TaskDetail();
            $task_detail->ended_at      = Carbon::now();
            $task_detail->end_status    = 'task_ended';
            $task_detail->task_id       = $task_id;
            $task_detail->employee_id   = $this->employee_id;
            $started_time               = $current->subSeconds($time);
            $task_detail->started_at    = $started_time;
            $is_saved                   = $task_detail->save();
            if($is_saved){
                $this->msg['status'] = 1;
            }else{
                $this->msg['status'] = 0;
            }
        }

        return response()->json($this->msg);
    }
    /******* Get Today Break Time *******/
    public function getBreaktime(){
        $id = request()->id;
        if(!empty($id)){
            $task = Task::where('title','break')->with(['taskDetail' => function($query) use ($id){
                $query->where('employee_id',$this->employee_id)
                ->whereDate('created_at', Carbon::today());
            }])->first();
            if($task->taskDetail->count() > 0){
                foreach ($task->taskDetail as $key => $value) {
                    $start_time = Carbon::parse($value->started_at);
                    $ended_at   = Carbon::parse($value->ended_at);
                    $totalDuration = $ended_at->diffInSeconds($start_time);
                    $this->msg['status'] = 1;
                    $this->msg['time_start'] = $totalDuration;
                }
            }else{
                $this->msg['status'] = 1;
                $this->msg['time_start'] = 1800;
            }
        }else{
            $this->msg['status'] = 0;
        }
        return response()->json($this->msg);
    }


    public function postBreakTime(){
        $time = request()->time;
        $task_type = request()->task_type;
        $employee_id = $this->employee_id;
        $task = Task::where('title',$task_type)->first();
        if($task){
            $current = Carbon::now();
            $task_detail = new TaskDetail();
            $task_detail->ended_at = Carbon::now();
            $task_detail->end_status = 'task_ended';
            $task_detail->task_id = $task->id;
            $task_detail->employee_id = $this->employee_id;
            $started_time = $current->subSeconds($time);
            $task_detail->started_at = $started_time;
            $is_saved = $task_detail->save();
            if($is_saved){
                $this->msg['status'] = 1;
            }else{
                $this->msg['status'] = 0;
            }
        }else{
            $this->msg['status'] = 0;
        }
        return response()->json($this->msg);
    }

    public function remarks(){
        $validatedData  =   request()->validate([
         'remarks'     =>  'required',
        ]);

      $delay_start_time = request()->delay_start_time;
      $delay_end_time = request()->delay_end_time;

       $remarks = request()->remarks;
       $type = 'idle';
       $task = Task::where('title',$type)->first();
       // dd(request());
       if($task){
        $task_detail = new TaskDetail();
        $task_detail->end_status = 'task_ended';
        $task_detail->task_id = $task->id;
        $task_detail->employee_id = $this->employee_id;
        $task_detail->started_at = $delay_start_time;
        $task_detail->ended_at = $delay_end_time;
        $task_detail->details = ['remarks' => $remarks];
        //dd($task_detail);
        $is_saved = $task_detail->save();
        if($is_saved){
            $this->msg['status'] = 1;
        }else{
            $this->msg['status'] = 0;
        }
       }else{
        $this->msg['status'] = 0;
       }
       return response()->json($this->msg);
    }


    function logout(Request $request)
    {
        //dd(request()->all());
        $idle_time_start = request()->idle_time_start;
        $idle_time_end = request()->idle_time_end;

        $task = Task::where('title','idle')->first();
       if($task){
            $task_detail = new TaskDetail();
            $task_detail->end_status = 'auto_closed';
            $task_detail->started_at = $idle_time_start;
            $task_detail->ended_at = $idle_time_end;
            $task_detail->task_id = $task->id;
            $task_detail->employee_id = $this->employee_id;

            $is_saved = $task_detail->save();
        }

      return  $this->logoutParent($request);
    }

    function endOfDay(Request $request)
    {
        $today = EmployeeAttandence::where('employee_id',$this->employee_id)
                                        ->whereRaw('DATE(started_at) = CURDATE()')
                                        ->where('ended_at',NULL)
                                        ->first();
        //dd($today);
        if($today):
           // $daystart = new EmployeeAttandence();
            $today->ended_at = Carbon::now();

            $today->save();
        endif;

        //dd('lll');
        return  $this->logoutParent($request);

    }
}
