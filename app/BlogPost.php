<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $table = 'blog_posts';

    public function user(){
    	return $this->belongsTo(User::class,'created_by','id');
    }

    

    public function blogPostCountry(){
    	return $this->hasMany(BlogPostRelationship::class,'blog_post_id','id')->where('type','country');
    }
    public function blogPostRelation(){
        return $this->hasMany(BlogPostRelationship::class,'blog_post_id','id');
    }
    public function blogShopaholicGroup(){
        return $this->hasMany(BlogPostRelationship::class,'blog_post_id','id')->where('type','shopaholic_group');
    }
     public function blogPostShopaholic(){
    	return $this->hasMany(BlogPostRelationship::class,'blog_post_id','id')->where('type','shopaholic');
    }
}
