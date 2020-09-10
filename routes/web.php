<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
});

Route::prefix('guides')->group(function() {
  Route::get('/', function() {
    return view('pages.guides');
  });

  Route::get('{uri}', function($uri) {
    return view('guides.'.$uri);
  });
});

Route::prefix('tools')->group(function() {
  Route::get('/', function () {
    return view('pages.tools');
  });

  Route::get('midi-meet', function() {
    return redirect('//midimeet.me/');
  });

  Route::get('{uri}', function($uri) {
    return view('tools.'.$uri);
  });
});

Route::prefix('experiments')->group(function() {
  Route::get('/', function () {
    return view('pages.experiments');
  });

  Route::get('{uri}', function($uri) {
    return view('experiments.'.$uri);
  });
});

Route::prefix('projects')->group(function() {
  Route::get('/', function () {
    return view('pages.projects');
  });

  Route::get('{uri}', function($uri) {
    return view('projects.'.$uri);
  });
});

Route::prefix('midimeet')->group(function() {
  Route::get('init', 'MidiMeetController@init');
  Route::post('join', 'MidiMeetController@join');
  Route::post('change-nickname', 'MidiMeetController@changeNickname');
});
