<?php

namespace blog\Http\Controllers;

use Illuminate\Http\Request;
use blog\Category;
use Session;

class CategoryController extends Controller
{
    public function __construct() {
      $this->middleware('auth');
      // only logged in users
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // display a view of all categories
        // aform to create a new category

        $categories = Category::all();

        return view('categories.index')->withCategories($categories);
    }

    ////// we don't need the create function /////

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // save a new category and redirect back to index
        $this->validate($request, [
          'name' => 'required|max:255|unique:blog_categories,name'
        ]);

        $category = new Category;

        $category->name = $request->name;
        $category->save();

        Session::flash('sucees', 'New Category has been created');

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
    }
}
