@extends('layout')

<title>what's in my rack | layetri</title>

@section('content')
  <div class="p-4 h-full">
    {{-- TODO: intro showreel --}}
    <div class="md:flex flex-row h-full">
      <div class="w-full lg:w-1/2 p-2">
        <h3 class="text-xl font-bold mb-2">What's in my rack?</h3>
        <small class="uppercase tracking-widest text-xs text-gray-400">Designed by me</small>
        <ul class="list-disc ml-4">
          <li><a class="text-teal-500" href="/projects/ko2b-makerskills-hills">Hills rev. 2</a></li>
          <li>USB Interface</li>
          <li>Clock Divider</li>
          <li>Gate Utility (invert, AND-gate)</li>
          <li>5 channel stereo mixer <small>based on design by Look Mum No Computer</small></li>
          <li>Passive Multiple</li>
          <li>RGB LED Controller</li>
        </ul>
        <br>

        <small class="uppercase tracking-widest text-xs text-gray-400">Designed by others</small>
        <ul class="list-disc ml-4">
          <li>
            <a class="text-teal-500" href="https://www.eddybergman.com/2019/11/synthesizer-build-part-3-envelope.html">AS3310 ADSR</a>
            <small>Eddy Bergman</small>
          </li>
          <li>
            <a class="text-teal-500" href="https://www.lookmumnocomputer.com/simple-filter">VCF</a>
            <small>Look Mum No Computer</small>
          </li>
          <li>
            <a class="text-teal-500" href="https://www.reddit.com/r/synthdiy/comments/fuxqb3/dual_vca_stripboard_layout_with_led_indicators/">AS3360 Dual VCA</a>
            <small>Duskwork, Look Mum No Computer</small>
          </li>
          <li>2x
            <a class="text-teal-500" href="https://www.reddit.com/r/synthdiy/comments/hsdijo/simple_roland_system_100m_lfo_diy_sharing/">LFO</a>
            <small>Roland System 100m, u/mxbob8</small>
          </li>
          <li>
            <a class="text-teal-500" href="https://lookmumnocomputer.discourse.group/t/schmitz-white-noise-generator/355">
              Noise Generator
            </a> (shared module with LFO)
            <small>René Schmitz</small>
          </li>
          <li>
            <a class="text-teal-500" href="https://www.lookmumnocomputer.com/mixer">Mixer</a>
            <small>Look Mum No Computer</small>
          </li>
          <li>
            2x <a class="text-teal-500" href="https://www.lookmumnocomputer.com/cem-3340-diy-simple">CEM3340 VCO</a>
            <small>Look Mum No Computer</small>
          </li>
          <li>
            <a class="text-teal-500" href="https://www.lookmumnocomputer.com/projects#/simple-envelope-generator">A/R Envelope Generator</a>
            <small>Look Mum No Computer</small>
          </li>
        </ul>
        <br>

        <small class="uppercase tracking-widest text-xs text-gray-400">Prebuilt</small>
        <ul class="list-disc ml-4">
          <li>CP1A Power Supply <small>Behringer</small></li>
        </ul>
      </div>
      <div class="w-full lg:w-1/2 p-2">
        <div class="w-full">
          <img class="shadow-lg rounded-lg border-4 border-white" src="/img/modular.jpeg" alt="Modular Synthesizer">
        </div>
      </div>
    </div>
  </div>
@endsection