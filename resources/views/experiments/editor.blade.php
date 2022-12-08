@extends('layout')

<title>vocal synth | layetri</title>

@section('content')
  <div class="lg:w-1/3 xs:w-100">
    <h1 class="text-3xl font-light">Formant Vocal Synth</h1>
    <p class="text-base font-light">An experiment using ToneJS to synthesize different vowels using a pulse oscillator and formant filters.</p>
  </div>

  <exp-editor></exp-editor>
@endsection