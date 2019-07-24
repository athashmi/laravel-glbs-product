<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageDetail extends Model
{
    protected $casts = [
        'details' => 'object',
    ];
}
