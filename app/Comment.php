<?php

namespace blog;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'blog_comments';

    public function post()
    {
      return $this->belongsTo('blog\Post');
    }
}
