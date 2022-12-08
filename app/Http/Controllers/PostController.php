<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function fetchAll() {
      return Post::where('public', 1)->get();
    }

    public function fetchAllAdmin() {
      return Post::get();
    }

    public function fetchOne($post) {
      return Post::where('public', 1)->where('slug', $post)->first();
    }

    public function store(Request $request) {
      $slug = strtolower(str_replace(['.', ',', '!', '?'], '', preg_replace("/\s+/", "-", $request->input('title'))));

      $post = Post::create([
          'title' => $request->input('title'),
          'user_id' => $request->user()->id,
          'slug' => $slug,
          'body' => $request->input('body'),
          'category' => $request->input('category'),
          'public' => $request->input('publish') || 0
      ]);

      return $post;
    }
}
