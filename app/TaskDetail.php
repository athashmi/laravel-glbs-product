<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    protected $casts = [
        'details' => 'object'
    ];
}
