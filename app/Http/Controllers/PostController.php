<?php

namespace blog\Http\Controllers;

use Illuminate\Http\Request;
use blog\Post;
use Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');//only authenticated users can access this page
    }
    public function index()
    {
        //create a variable and store all the blog posts in it from the db
        $posts = Post::orderBy('id', 'desc')->paginate(5);//desc: descending

        //return a view and pass in the above variable
        return view('posts.index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            //alpha_dash: alpha-numeric characters, as well as dashes and underscores
            //go to the slug column in posts table and see if this item is unique
            'body' => 'required',
            ));

        //store in the db
        $post = new Post;

        $post->title = $request->title;
        $post->body = $request->body;
        $post->slug = $request->slug;

        $post->save();//save to the db

        Session::flash('success', 'the Blog post is successfully saved!');

        //redirect to another page
        return redirect()->route('posts.show', $post->id);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //find the post in the db and save as a variable
        $post = Post::find($id);//find a post by the id no.

        //return the view and pass in the var previously created
        return view('posts.edit')->withPost($post);//posts.edit means posts/edit.blade.php
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validate the data
        $post = Post::find($id);//find the post with this $id

        if ( $request->input('slug') == $post->slug ){
          $this->validate($request, array(
              'title' => 'required|max:255',
              'body' => 'required'
              ));
        }
        else {
        $this->validate($request, array(
            'title' => 'required|max:255',
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'body' => 'required'
            ));
          }

        //save the data to the db
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->body = $request->input('body');
        $post->save();

        //set flash data with success msg.
        Session::flash('success', 'the Blog post is successfully Updated!');

        //redirect with flash data to posts.show
        return redirect()->route('posts.show', $post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);

        $post->delete();
        Session::flash('success', 'the Blog post is successfully Deleted!');

        return redirect()->route('posts.index');
    }
}
