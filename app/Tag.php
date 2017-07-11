<?php

namespace blog;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'blog_tags';

    public function posts()
    {
      return $this->belongsToMany('blog\Post', 'post_tag', 'tag_id', 'post_id');
    }
}
