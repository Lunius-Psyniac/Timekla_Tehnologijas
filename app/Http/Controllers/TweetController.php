<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Tweet;

class TweetController extends Controller
{
    //

    public function index(){
        $tweets = Tweet::all();
        dd($tweets);
    }
}
