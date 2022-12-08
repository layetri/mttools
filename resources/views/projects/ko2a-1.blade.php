@extends('layout')

<title>live looper | layetri</title>
<link rel="stylesheet" href="{{secure_asset('project/ko2a-1/style.css')}}">

@section('content')
  <div class="lg:w-1/3 xs:w-100">
    <h1 class="text-3xl font-light">KO2a-1: Live Looping</h1>
    <p class="text-base font-light">A live looper/sampler using ToneJS.</p>
  </div>

  <ko2a-looper></ko2a-looper>
@endsection