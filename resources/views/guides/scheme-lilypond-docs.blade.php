@extends('layout')

<title>Scheme to LilyPond | mttools</title>
<link rel="stylesheet" href="{{asset('css/guide.css')}}">

@section('content')
  <div class="w-2/3 mb-10">
    <h1>Scheme to LilyPond</h1>
    <hr>
    <h5>Introduction</h5>
    <p>This document briefly explains all functions included in the HKU LilyPond extension for Racket found at <a href="https://github.com/marcdinkum/csd">marcdinkum/csd</a>. If you discover any errors in this document, please contact me at mt@layetri.nl.</p>
    <br>

    <h5>Table of Contents</h5>
    <ul>
      <li><a href="#make-phrase">make-phrase</a></li>
      <li><a href="#make-parallel">make-parallel</a></li>
      <li><a href="#note-to-number">note-to-number</a></li>
      <li><a href="#notes-to-numbers">notes-to-numbers</a></li>
      <li><a href="#transpose-natural">transpose-natural</a></li>
      <li><a href="#transpose-naturals">transpose-naturals</a></li>
      <li><a href="#transpose-note">transpose-note</a></li>
      <li><a href="#transpose-phrase">transpose-phrase</a></li>
      <li><a href="#scale-length">scale-length</a></li>
      <li><a href="#scale-note-length">scale-note-length</a></li>
      <li><a href="#merge-phrases">merge-phrases</a></li>
      <li><a href="#merge-phraselist">merge-phraselist</a></li>
      <li><a href="#repeat-phrase">repeat-phrase</a></li>
      <li><a href="#reverse-phrase">reverse-phrase</a></li>
      <li><a href="#apply-transform">apply-transform</a></li>
    </ul>
    <br>

    <scheme-lilypond-docs></scheme-lilypond-docs>
  </div>
@endsection