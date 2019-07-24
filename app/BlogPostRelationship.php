<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPostRelationship extends Model
{
    protected $table = 'blog_post_relationships';

    public function country(){
    	return $this->belongsTo(Country::class,'object_id','id');
    }
    public function shopaholic(){
        return $this->belongsTo(Shopaholic::class,'object_id','id');
    }
    public function user(){
    	return $this->belongsTo(User::class,'object_id','id');
    }
    public function shopaholicGroup(){
        return $this->belongsTo(ShopaholicGroup::class,'object_id','id');
    }

    public function post(){
    	return $this->belongsTo(BlogPost::class,'blog_post_id','id');
    }
}
