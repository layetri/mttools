@extends('layout')

<title>Admin | layetri</title>

@section('content')
  <div class="p-4 h-full">
    <admin-container :user="{{ Auth::user() }}"></admin-container>
  </div>
@endsection