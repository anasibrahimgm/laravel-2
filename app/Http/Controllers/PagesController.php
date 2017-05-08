<?php

namespace blog\Http\Controllers;

use Illuminate\Http\Request;

use blog\Http\Requests;
use blog\Post;
use Mail;
use Session;

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

	public function postContact(Request $request) {
		$this->validate($request, [
			'email' => 'required| email',
			'subject' => 'min:3',
			'message' => 'min:10'
		]);

		$data = [
			'email' => $request->email,
			'subject' => $request->subject,
			'bodyMessage' => $request->message//we can't use a variable called message in emails
		];

		Mail::send('emails.contact', $data, function($message) use($data) {//we can use queue method to send in the background (if we want to send a lot of msgs)
					$message->from($data['email']);
					$message->to('anasibrahimgm@gmail.com');
					$message->subject($data['subject']);
			});

		Session::flash('success', 'Your Email was Sent');

		return redirect('/');
	}
}
