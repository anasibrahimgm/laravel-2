<?php

namespace blog\Http\Controllers;

use Illuminate\Http\Request;
use blog\Post;
use Session;
use blog\Category;
use blog\Tag;
use Purifier;
use Image;

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
        // grab all categories and send them to
        // the form to be able to choose from them
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create')->withCategories($categories)->withTags($tags);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);// die and dump
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
        $post->body = Purifier::clean($request->body);
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;

        if ($request->hasFile('featured_image')) {
          $image = $request->file('featured_image');
          $fileName = time() . '.' . $image->getClientOriginalExtension();// we can use  $image->encode('png');
          $location = public_path('images/'. $fileName);// storage_path
          Image::make($image)->resize(800, 400)->save($location);

          $post->image = $fileName;
        }

        $post->save();//save to the db

        $post->tags()->sync($request->tags, false);
        // false : don't overwrite existing associations

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
        $categories = Category::all();
        //another way to show categories
        $cats = [];
        foreach ($categories as $category) {
          $cats[$category->id] = $category->name;
        }

        $tags = Tag::all();
        $tags2 = [];
        foreach ($tags as $tag){
          $tags2[$tag->id] = $tag->name;
        }

        //return the view and pass in the var previously created
        return view('posts.edit')->withPost($post)->withCategories($cats)->withTags($tags2);//posts.edit means posts/edit.blade.php
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
        $post->body = Purifier::clean($request->input('body'));
        $post->category_id = $request->input('category_id');
        $post->save();

        if (isset($request->tags)){
          $post->tags()->sync($request->tags);
          // is is true by default
        } else {
          $post->tags()->sync(array());
        }


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
        $post->tags()->detach();

        $post->delete();
        Session::flash('success', 'the Blog post is successfully Deleted!');

        return redirect()->route('posts.index');
    }
}
