<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'href', 'project_url', 'image', 'course', 'label', 'personal', 'interactive', 'github', 'youtube'];
}
