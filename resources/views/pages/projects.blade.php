@extends('layout')

<title>projects | mttools</title>

@section('content')
  <div class="p-4">
    <h1 class="text-3xl font-bold">Projects</h1>
    <p class="text-base font-light mb-4">This page contains personal projects and things developed at HKU.</p>

    <projects-list></projects-list>
  </div>
@endsection