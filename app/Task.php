<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function taskDetail(){
    	return $this->hasMany(TaskDetail::class,'task_id','id');
    }
}
