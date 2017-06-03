<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
   protected $table = 'tags'; //
   
   public function cposts()
   {
     return $this->belongsToMany('App\Post', 'ptags', 'tags_id', 'post_id');
   }
}
