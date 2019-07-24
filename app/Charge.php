<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
	protected $guarded = ['id'];
    protected $casts = [
        'applicable_module' => 'object'
    ];
}
