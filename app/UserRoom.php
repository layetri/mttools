<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoom extends Model
{
    protected $fillable = ['user_id', 'room'];
}
