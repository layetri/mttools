@extends('layout')

<title>blog | layetri</title>

@section('content')
  <div class="p-4 h-full flex">
    <div class="flex-auto p-4">
      <post :post_slug="'{{ $post }}'"></post>
    </div>
    <div class="w-1/4 p-4">
      <blog-sidebar></blog-sidebar>
    </div>
  </div>
@endsection