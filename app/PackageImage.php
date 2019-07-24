<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageImage extends Model
{
     protected $casts = [
        'created_at' => 'datetime:F m,Y',
    ];
    
}
