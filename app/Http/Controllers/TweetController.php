<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;

class TweetController extends Controller
{
    //

    public function index(){
        $tweets = Tweet::all();
        return view('tweetList', compact('tweets'));
    }
}
