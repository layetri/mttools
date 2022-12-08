<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function fetch(Request $request) {
      $projects = Project::orderBy('created_at', 'desc')->get();
      foreach($projects as $project) {
        try {
          $project->content = Storage::get('/public/library/portfolio/' . $project->href . '/content.json');
        } catch (FileNotFoundException $e) {
          $project->content = false;
        }
      }

      return $projects;
    }

    public function loadOne($name) {
      $p = Project::where('href', $name)->first();
      try {
        $p->content = Storage::get('/public/library/portfolio/' . $p->href . '/content.json');
      } catch (FileNotFoundException $e) {
        $p->content = false;
      }
      return $p;
    }

    public function fetchFeatured() {
      $projects = Project::where('highlight', 1)->latest()->take(2)->get();
//      foreach($projects as $project) {
//        $project->is_new = $project->created_at >
//      }
      return $projects;
    }

    public function store(Request $request) {
      // Generalize database array
      $database_values = $request->only('name', 'project_url', 'github', 'youtube', 'interactive', 'personal', 'highlight', 'course', 'label');

      // Generate a URL
      $href = strtolower(str_replace(" ", "-", str_replace([".", ";", ":", "@", "/", "|"], "", $request->input('name'))));

      // Image storage
      if($request->image) {
        $file = Storage::putFile('/public/library/portfolio/' . $href, $request->image, 'public');
        $file_url = Storage::url($file);
        $database_values['image'] = $file_url;
      }

      // Store the page content file
      Storage::put('/public/library/portfolio/' . $href . '/content.json', $request->input('content'));


      $database_values['href'] = $href;

      if($request->input('action') === 'create') {
        $database_values['description'] = $request->input('name');

        $project = Project::create($database_values);
      } elseif($request->input('action') === 'edit') {
        $project = Project::where('id', $request->input('id'))->first();
        $project->update($database_values);
      }

      return $project;
    }
}
