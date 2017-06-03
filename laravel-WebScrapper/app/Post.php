<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   protected $table = 'posts'; //
   
   public function ptags()
   {
     return $this->belongsToMany('App\Tag', 'ptags', 'post_id', 'tags_id');
   }
   
    public function ptopics()
   {
     return $this->belongsToMany('App\Category', 'ptopics', 'post_id', 'category_id');
   }

  
   
   
}
