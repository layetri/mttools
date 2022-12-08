@extends('layout')

<title>{{$project}} | layetri</title>

@section('content')
  <project-view pid="{{$project}}"></project-view>
@endsection