<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Package extends Model
{
    protected $guarded = ['id'];
     protected $casts = [
        'free_services' => 'object',
        'created_at' => 'datetime:D, d  M  Y',
    ];
    
    public function primaryThumbnail(){
    	return $this->hasOne(PackageImage::class,'package_id','id')->where('size_type','thumbnail')->where('type','primary');
    }
    public function primaryFullImage(){
        return $this->hasOne(PackageImage::class,'package_id','id')->where('size_type','full')->where('type','primary');
    }

    public function images(){
        return $this->hasMany(PackageImage::class,'package_id','id');
    }


    public function secondaryThumbs(){
        return $this->hasMany(PackageImage::class,'package_id','id')->where('size_type','thumbnail')->where('type','!=','primary');
    }


    public function fullImages(){
        return $this->hasMany(PackageImage::class,'package_id','id')->where('size_type','full');
    }

     public function childPackages(){
        return $this->hasMany(Package::class,'parent_package_id','id');
    }

    public function parentPackage(){
        return $this->belongsTo(Package::class,'parent_package_id','id');
    }

    public function childSortedPackages(){
        return $this->hasMany(Package::class,'parent_package_id','id')->where('status','sorted');
    }

    public function warehouseShelf(){
    	return $this->belongsTo(WarehouseShelf::class,'warehouse_shelf_id','id')->where('usage_type','package');
    }
    public function paidService(){
        return $this->hasMany(PackageServiceRequests::class,'package_id','id');
    }
    public function packageCustomDetail(){
        return $this->hasMany(PackageCustomDetail::class,'object_id','id')->where('object_type','package');
    }

    public function packageActions(){
        return $this->hasMany(PackageDetail::class,'package_id','id');
    }

    public function packagePicked(){
        return $this->hasOne(PackageDetail::class,'package_id','id')->where('action_status','picked');
    }
    public function found(){
        return $this->hasOne(PackageDetail::class,'package_id','id')->orderBy('created_at','Desc');
    }

     
    

    
    
    
}
