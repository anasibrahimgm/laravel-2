<?php

namespace blog\Http\Controllers;

use Illuminate\Http\Request;
use blog\Post;
class PagesController extends Controller
{
	public function getIndex() {
		$posts = Post::orderBy('created_at', 'desc')->limit(4)->get();  // don't have to use DB::table() because we made the Post model
		return view('pages.welcome')->withPosts($posts);

	}

	public function getAbout() {
		///////////////////
		/*
		$name = 'Anas';
		return view('pages.about')->with("name", $name);
		*/
		/////////////////

		////////////////
		/*
		$data = [];
		$data['email'] = 'anasibrahimgm@mail';
		$data['name']= 'Anas';
		return view('pages.about')->withData($data);
		*/
		////////////

		///////////////
		/*
		$name= 'Anas';
		return view('pages.about')->withName($name)->withEmail('anasibrahimgm@gmail');
		*/
		////////////
		return view('pages.about');


	}

	public function getContact() {
		return view('pages.contact');

	}
}
