@extends('layout')

<title>{{$project}} | mttools</title>

@section('content')
  <project-view pid="{{$project}}"></project-view>
@endsection