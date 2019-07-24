<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseShelf extends Model
{
    //
    protected $table = 'warehouse_shelves';
    protected $guarded = ['id'];

    public function warehouse(){
    	return $this->belongsTo(Warehouse::class);
    }
}
