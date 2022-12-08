@extends('layout')

<title>granular effect | layetri</title>
<link rel="stylesheet" href="{{secure_asset('project/ko2a-1/style.css')}}">

@section('content')
  <div class="lg:w-1/3 xs:w-100 mb-4">
    <h1 class="text-3xl font-light">KO2a-3: Granular Effect</h1>
    <p class="text-base font-light">A complex granular effect built using ToneJS.</p>
  </div>

  <ko2a-granular></ko2a-granular>
@endsection