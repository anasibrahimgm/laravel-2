<?php

namespace blog\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
	public function getIndex() {
		return view('pages.welcome');

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