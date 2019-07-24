<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsolidationRequestActionDetail extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'details' => 'object',
    ];
}
