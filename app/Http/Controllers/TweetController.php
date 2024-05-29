<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    //

    public function index(){
        $tweets = Tweet::with('user')->get();
        // dd($tweets->toArray());
        return view('tweetList', compact('tweets'));
    }

    public function addTweet(Request $request){
        $title = $request->input('title');
        $text = $request->input('text');

        $tweet = new Tweet();

        $tweet->title=$title;
        $tweet->content=$text;
        $tweet->user_id=Auth::id();
        $tweet->save();
        $tweets = Tweet::with('user')->get();
        
        return 200;
    }

    public function delete(Request $request)
    {
        $id = $request->input('id')['index'];
        $tweetToDelete = Tweet::find($id);
        $tweetToDelete->delete();

        return 200;
        // $index = $request->input('index');
        // $items = session()->get('items', []);
        // unset($items[$index]);
        // session()->put('items', $items);

        // return response()->json(['items' => $items]);
    }
}
