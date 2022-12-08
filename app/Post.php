<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'user_id', 'slug', 'body', 'category', 'public', 'image'];

    public function user() {
      return $this->belongsTo(User::class);
    }
}
