<?php

namespace blog;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'blog_posts';
    
    public function category()
    {
      return $this->belongsTo('blog\Category');
    }

    public function tags()
    {
      return $this->belongsToMany('blog\Tag');
    }

    public function comments()
    {
      return $this->hasMany('blog\Comment');
    }
}
