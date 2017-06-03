<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $table = 'category'; //
   
   public function cposts()
   {
     return $this->belongsToMany('App\Post', 'ptopics', 'category_id', 'post_id');
   }
   
}
