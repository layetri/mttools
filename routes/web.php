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
    return view('pages.new_home');
});
Route::get('whats-in-my-rack', function () {
    return view('pages.rack');
});
Route::get('donut', function () {
    return view('pages.donut');
});

Route::prefix('student')->group(function() {
  Route::get('/', function() {
    return view('pages.student');
  });

  Route::prefix('guide')->group(function() {
    Route::get('{uri}', function($uri) {
      return view('guides.'.$uri);
    });
  });
});

Route::prefix('blog')->group(function() {
  Route::get('/', function () {
    return view('blog.list');
  });

  Route::get('post/{post}', function($post) {
    $data['post'] = $post;
    return view('blog.post')->with($data);
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

  Route::get('{uri}/run', function($uri) {
    return view('projects.'.$uri);
  });

  Route::get('{uri}', function($uri) {
    $data['project'] = $uri;
    return view('projects.view')->with($data);
  });
});

Route::get('login', function() {
  return view('admin.login');
})->middleware(['redirectIfLoggedIn']);
Route::post('login', 'AuthController@login');

Route::middleware(['administrator'])->group(function () {
  Route::prefix('admin')->group(function () {
    Route::get('/', function () {
      return view('admin.view');
    });
  });

  Route::prefix('fetch')->group(function() {
    Route::get('blog/posts', 'PostController@fetchAllAdmin');
  });
  Route::prefix('make')->group(function() {
    Route::post('project', 'ProjectController@store');
    Route::post('blog/post', 'PostController@store');
  });
});

Route::prefix('fetch')->group(function() {
  Route::get('projects', 'ProjectController@fetch');
  Route::get('projects/featured', 'ProjectController@fetchFeatured');
  Route::get('project/{project}', 'ProjectController@loadOne');

  Route::get('blog/posts', 'PostController@fetchAll');
  Route::get('blog/post/{post}', 'PostController@fetchOne');
});

Route::prefix('midimeet')->group(function() {
  Route::get('init', 'MidiMeetController@init');
  Route::post('join', 'MidiMeetController@join');
  Route::post('change-nickname', 'MidiMeetController@changeNickname');
});
