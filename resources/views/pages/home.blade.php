@extends('layout')

<title>home | layetri</title>

@section('content')
  <div class="p-4 h-full">
{{-- TODO: intro showreel --}}
    <div class="md:flex flex-row h-full">
      <div class="md:w-1/3 p-2">
        <h1 class="text-2xl font-bold">Hi, I'm Dani&euml;l.</h1>
        <p class="text-base font-light">I'm a music technology student at HKU University of the Arts in Utrecht, the Netherlands, where I specialize in Creative Systems Design and Sonic Arts. Outside of school, I like to work on various projects like <a href="https://www.pettenvolk.com" class="text-teal-500">Pettenvolk</a> and my DIY modular synthesizer.</p>

        <a href="/donut" class="block px-4 py-2 mt-4 rounded-xl shadow-md bg-yellow-400 hover:bg-yellow-500 text-white font-semibold text-sm">
          <span class="font-bold text-yellow-100">New!</span> <span>I made a synthesizer called Donut</span>
        </a>

        <div class="p-5">
          <hr>
        </div>

        <div class="text-bold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
          <small>Connect with me</small>
        </div>
{{-- TODO: new tab --}}
        <div class="w-2/3 mx-auto p-3">
          <div class="flex inline-flex w-full text-center text-gray-400 select-none">
            <div class="flex-auto p-2 hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer">
              <a href="https://github.com/layetri" target="_blank">
                <i class="fab text-black dark:text-white text-2xl fa-github mb-2"></i><br>
                <small class="uppercase tracking-wide text-xs">layetri</small>
              </a>
            </div>

            <div class="flex-auto p-2 hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer">
              <a href="https://soundcloud.com/layetri" target="_blank">
                <i class="fab text-orange-500 text-2xl fa-soundcloud mb-2"></i><br>
                <small class="uppercase tracking-wide text-xs">layetri</small>
              </a>
            </div>

            <div class="flex-auto p-2 hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer">
              <a href="https://twitter.com/layetri_p" target="_blank">
                <i class="fab text-blue-400 text-2xl fa-twitter mb-2"></i><br>
                <small class="uppercase tracking-wide text-xs">layetri_p</small>
              </a>
            </div>
          </div>
        </div>

        <div class="p-5">
          <hr>
        </div>

        <div class="text-bold text-gray-600 dark:text-gray-300 uppercase tracking-wide w-full flex">
          <small class="flex-auto">Tools & Skills</small>
          <small class="text-xs text-teal-400">
            <a href="https://stackshare.io/layetri">View full stack</a>
          </small>
        </div>

        <div class="w-11/12 mx-auto p-3">
          <div class="flex inline-flex w-full text-center text-gray-400 cursor-default select-none">
            <div class="flex-auto p-2 hover:text-gray-600 dark:hover:text-gray-200">
              <i class="devicon-laravel-plain text-red-400 text-2xl mb-2"></i><br>
              <small class="uppercase tracking-wide text-xs">Laravel</small>
            </div>
            <div class="flex-auto p-2 hover:text-gray-600 dark:hover:text-gray-200">
              <i class="devicon-vuejs-plain text-teal-400 text-2xl mb-2"></i><br>
              <small class="uppercase tracking-wide text-xs">Vue</small>
            </div>
            <div class="flex-auto p-2 hover:text-gray-600 dark:hover:text-gray-200">
              <i class="devicon-cplusplus-plain text-blue-500 text-2xl mb-2"></i><br>
              <small class="uppercase tracking-wide text-xs">C++</small>
            </div>
            <div class="flex-auto p-2 hover:text-gray-600 dark:hover:text-gray-200">
              <i class="devicon-python-plain text-yellow-300 text-2xl mb-2"></i><br>
              <small class="uppercase tracking-wide text-xs">Python</small>
            </div>
            <div class="flex-auto p-2 hover:text-gray-600 dark:hover:text-gray-200">
              <i class="devicon-javascript-plain text-yellow-500 text-2xl mb-2"></i><br>
              <small class="uppercase tracking-wide text-xs">JS</small>
            </div>
            <div class="flex-auto p-2 hover:text-gray-600 dark:hover:text-gray-200">
              <i class="devicon-git-plain text-orange-500 text-2xl mb-2"></i><br>
              <small class="uppercase tracking-wide text-xs">Git</small>
            </div>
          </div>
        </div>
      </div>

      <div class="md:flex-auto"></div>

      <div class="md:w-1/3 h-full">
        <featured-projects></featured-projects>
      </div>

      <div class="hidden">
        <h1 class="text-xl font-bold">What's new</h1>
        <div class="text-bold text-gray-400 mt-4 uppercase tracking-wide">
          <small>No news yet...</small>
        </div>
  {{--      <div class="p-4">--}}
  {{--        <span>Hills rev2 was released</span><br>--}}
  {{--        <div class="flex inline-flex w-full">--}}
  {{--          <small class="text-gray-600 flex-auto">read more</small>--}}
  {{--          <small class="text-gray-600"><i>one day ago</i></small>--}}
  {{--        </div>--}}
  {{--      </div>--}}
  {{--      <hr>--}}
  {{--      <div class="p-4">--}}
  {{--        <span>Hills rev2 was released</span><br>--}}
  {{--        <small class="text-gray-600"><i>one day ago</i></small>--}}
  {{--      </div>--}}
  {{--      <hr>--}}
      </div>
    </div>
  </div>
@endsection