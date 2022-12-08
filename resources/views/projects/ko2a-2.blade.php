@extends('layout')

<title>complex delay | layetri</title>
<link rel="stylesheet" href="{{secure_asset('project/ko2a-1/style.css')}}">

@section('content')
  <div class="lg:w-1/3 xs:w-100 mb-4">
    <h1 class="text-3xl font-light">KO2a-2: Complex Delay</h1>
    <p class="text-base font-light">A complex delay effect built using ToneJS.</p>
  </div>

  <ko2a-delay></ko2a-delay>
@endsection