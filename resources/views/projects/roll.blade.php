<!DOCTYPE html>
<html lang="nl">
  <head>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('project/roll/css/world.css') }}">

    <script
        src="https://code.jquery.com/jquery-3.5.0.min.js"
        integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
        crossorigin="anonymous"></script>
    <script src="{{ asset('project/roll/js/p5.min.js') }}"></script>
    <script src="{{ asset('project/roll/js/addons/p5.dom.min.js') }}"></script>
    <script src="{{ asset('project/roll/js/addons/p5.sound.min.js') }}"></script>
    <script src="{{ asset('project/roll/js/oscLib.js') }}"></script>

    <script src="{{ asset('project/roll/resources/Player.js') }}"></script>
    <script src="{{ asset('project/roll/resources/World.js') }}"></script>
    <script src="{{ asset('project/roll/resources/Terrain.js') }}"></script>
    <script src="{{ asset('project/roll/resources/Obstacle.js') }}"></script>
    <script src="{{ asset('project/roll/resources/sketch.js') }}"></script>

    <title>Eindopdracht SYSBAS 19/20</title>
  </head>

  <body>
    <h4 class="absolute text-white ml-2 mt-10 bit-regular text-4xl">r0LL</h4>
    <h4 class="absolute text-white ml-2 mt-20 bit-regular text-lg">
      <small class="text-sm">&copy;</small> 2020 unluca and Layetri
    </h4>
    <input class="absolute px-3 m-2 bit-regular text-xl" style="width: 4rem;" type="number" value="120" id="len_box" placeholder="length">

    <div class="absolute bg-white top-0 right-0 p-2">
      <a href="https://layetri.github.io/sysbas1-eind/" class="text-blue-700">GitHub</a>
    </div>

    <div class="infoBar">
      <div class="container mx-auto">
        <div class="flex text-center">
          <div class="flex-auto w-1/5 text-white">
            <h4 class="text-5xl m-0 bit-regular" id="speedDisplay">0</h4>
            <small class="text-lg bit-regular uppercase">speed</small>
          </div>
          <div class="flex-auto w-1/5 text-white">
            <h4 class="text-5xl m-0 bit-regular" id="spinDisplay">0</h4>
            <small class="text-lg bit-regular uppercase">angle</small>
          </div>
          <div class="flex-auto w-1/5">
            <h4 class="text-5xl m-0 bit-regular cursor-pointer text-green-200" id="startBtn">
              start
            </h4>
          </div>
          <div class="flex-auto w-1/5 text-white">
{{--          Just empty space  --}}
          </div>
          <div class="flex-auto w-1/5 text-white">
            <h4 class="text-5xl m-0 bit-regular" id="clock">0:00</h4>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>