@extends('layout')

<title>guides | layetri</title>

@section('content')
  <div class="p-4">
    <div class="sm:w-full md:w-2/5">
      <h1 class="text-2xl font-bold">for MT students</h1>
      <p class="text-base font-light">On this page I post tools and guides for MT students.</p>

      <div class="p-5">
        <hr>
      </div>

      <div class="text-bold text-gray-600 uppercase tracking-wide">
        <small>Tools</small>
      </div>

      <tools-list></tools-list>

      <div class="p-5">
        <hr>
      </div>

      <div class="text-bold text-gray-600 uppercase tracking-wide">
        <small>Guides</small>
      </div>

      <guides-list></guides-list>
    </div>
  </div>
@endsection