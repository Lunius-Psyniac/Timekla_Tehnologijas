<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\YourController;
use App\Http\Controllers\ItemController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/tweets', [TweetController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::post('/add-tweet', [TweetController::class, 'addTweet'])
    ->name('add.tweet');


Route::post('/delete-item', [TweetController::class, 'delete'])
    ->name('delete.item');

require __DIR__.'/auth.php';
