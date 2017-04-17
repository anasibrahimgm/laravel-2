<?php

namespace blog\Http\Controllers;

use Illuminate\Http\Request;
use blog\Post;

class BlogController extends Controller
{
    public function getSingle($slug) {
      // fetch from the db based on slug
      $post = Post::where('slug', '=', $slug)->first();// gets the first one

      // return the view and pass in the post object
      return view('blog.single')->withPost($post);
    }
}
