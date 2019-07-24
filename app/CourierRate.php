<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourierRate extends Model
{
    protected $casts = [
        'country_ids' => 'object'
    ];
}
