<template>
  <div>
    <div class="w-full h-1/2" id="donutHeader">
      <div class="h-full w-full bg-opacity-50 bg-gray-500 text-white text-center flex flex-row items-center">
        <div class="mx-auto">
          <h1 class="text-5xl font-light">"I want a synth that can do <br> <span class="font-bold text-yellow-300">everything</span>."</h1>
          <span class="font-light text-xl italic">- me, March 2022</span>
        </div>
      </div>
    </div>

    <div class="w-full lg:w-2/3 mx-auto p-8 mb-8">
      <div id="intro" class="lg:w-2/3">
        <h4 class="text-xl font-semibold"><span class="font-bold text-yellow-600">Hi!</span> I'm Layetri.</h4>
        <p class="text-lg font-light">For my third year project at HKU (University of the Arts Utrecht, the Netherlands), I've spent the past three months working full-time on building my own digital synthesizer. This page tells the story of its creation, details future plans, and explains how you can obtain your very own Donut!</p>
      </div>
    </div>

    <div class="w-full lg:w-2/3 mx-auto p-8 mb-8">
      <div id="timeline">
        <h1 class="font-bold text-4xl mb-4">From Zero to Donut</h1>
        <div class="w-full flex flex-row">
          <div class="lg:w-2/3">
            <h4 class="text-xl font-semibold"><span class="font-bold text-yellow-600 mr-4">November 2021</span> I have an idea</h4>
            <p>The first idea that led to Donut's creation was actually very different than the direction the project is currently taking. I came up (half-jokingly) with the concept of a synthesizer that uses a model of a donut throughout its entire synthesis path. Filters, modulation, sound sources, and effects would all be based on the general shape of this sweet snack. It would also include a granular effect that would "add the sprinkles on top". I started building a prototype for this concept in my spare time, putting special attention towards polyphony algorithms that would power this thing.</p>

            <h4 class="text-xl font-semibold mt-4"><span class="font-bold text-yellow-600 mr-4">March 2022</span> I need a project, and fast</h4>
            <p>Fast forward a few months, I was making steady progress in my free time. However, for my third year project at HKU (University of the Arts, Utrecht), I had to come up with an idea for a project after a group effort fell through. At that moment, I decided to start working on Donut full-time. This also meant defining the scope of the project, and thus the "synth that does everything" was born.</p>

            <div class="m-4 p-4 bg-yellow-400 text-white rounded-xl shadow-md">
              <h1 class="font-bold text-2xl">The Pitch</h1>
              <p class="text-sm mb-2">In March, I pitched my idea in class. This presentation outlined an idea for a synthesizer that would contain the following:</p>
              <div class="w-full flex flex-col lg:flex-row text-sm">
                <div class="lg:w-1/2">
                  <h5 class="text-base font-bold">Things that were already there</h5>
                  <ul class="list list-disc ml-4">
                    <li><span class="text-gray-100 text-xs uppercase">2x</span> WaveTable oscillator</li>
                    <li><span class="text-gray-100 text-xs uppercase">2x</span> additive WaveShaper</li>
                    <li><i>n</i>-voice polyphony</li>
                    <li>Presets system</li>
                  </ul>
                </div>

                <div class="lg:w-1/2">
                  <h5 class="text-base font-bold">Things I wanted to add</h5>
                  <ul class="list list-disc ml-4">
                    <li>Stereo effects</li>
                    <li>More sound sources <ul class="list list-disc ml-4">
                      <li>Complex physical modeling engine</li>
                      <li>Granular engine</li>
                    </ul></li>

                    <li>Modulation matrix of sorts</li>
                  </ul>
                </div>
              </div>

              <p class="text-sm mt-4">Besides these software features, I wanted to create a hardware synthesizer that could be used as a standalone instrument on stage, complete with integrated keybed and controls. This hardware implementation would be based around a <b>Raspberry Pi 4B</b> mini computer, and use a bare metal framework to run the firmware as close to the CPU as possible.</p>
            </div>

            <h4 class="text-xl font-semibold mt-4"><span class="font-bold text-yellow-600 mr-4">April 2022</span> devlogs and feature bloat</h4>
            <p>In late March, I created the first Donut Devlog video, demonstrating the current sound of the software. I used these videos to log my progress week by week(-ish). The first four videos were created during April, giving a broad overview of the progress made during this month:</p>
            <div class="w-full flex flex-row text-center my-2">
              <div class="flex-auto">
                <a href="https://youtu.be/OLlrPg6xvhI">Devlog I</a>
              </div>

              <div class="flex-auto">
                <a href="https://youtu.be/XgsYKxt4CRc">Devlog II</a>
              </div>

              <div class="flex-auto">
                <a href="https://youtu.be/7CKzSvlqjKY">Devlog III</a>
              </div>

              <div class="flex-auto">
                <a href="https://youtu.be/irrRvemUZCc">Devlog IV</a>
              </div>
            </div>
            <p>April saw the biggest number of features added. A few notable additions are the <i>Tensions</i> physical modeling engine, the <i>Sampler</i> instrument, and the internal <i>Parameter</i> control handling system.</p>

            <h4 class="text-xl font-semibold mt-4"><span class="font-bold text-yellow-600 mr-4">May 2022</span> sanitizing and polishing</h4>
            <p>When most systems were in place, I started working on cleaning up the output audio. There were a lot of artifacts and clicks in the output, partially caused by problems in rendering and bugs in the audio engine connector. When the main issue with the JACK connector was resolved, I focused on decreasing processing times and making the system more stage-ready. This included things like separating the synthesis thread from the actual audio engine connector, and tweaking the gain staging for all the steps in the processing chain.</p>

            <h4 class="text-xl font-semibold mt-4"><span class="font-bold text-yellow-600 mr-4">The Future</span> after the project deadline</h4>
            <p>When the project at HKU is over, the work has only just begun. I have a long list of features I'm still planning to add. First and foremost, I will be focusing more on the hardware side of things, finalizing the first design and getting a prototype PCB made. After hopefully not too many iterations, the schematics and board designs will be published on this site. Besides hardware, I will be implementing the missing effects and filters. I'm especially looking forward to building the glitch effect, as it will add sonic capabilities to my setup that I don't currently have. I'll also work on a GUI overhaul, combining custom OpenGL elements with the current GUI library to create a more polished and integrated experience.</p>

          </div>

          <div class="hidden lg:flex lg:w-1/3 flex-row items-start">
            <img style="position:sticky;top:50px;" src="/img/donut_sider1.png" alt="">
          </div>
        </div>
      </div>
    </div>


    <div class="w-full lg:w-2/3 mx-auto p-8">
      <div id="system-overview">
        <h1 class="font-bold text-4xl mb-4">...but how does it work?</h1>
        <div class="lg:w-2/3 mb-4">
          <h4 class="font-bold text-xl">About Note Handling</h4>
          <p>Donut uses a round-robin algorithm to assign notes in the most natural way. This means that each incoming note is assigned to the next voice, no matter the state of the previous voices. Because of this assignment method, note releases are preserved as long as possible. This results in a more comprehensive output sound. If all 12 voices are already in use, Donut will look for the voice that has been assigned the earliest and "steal" it to play a new note.</p>
        </div>

        <h4 class="font-bold text-xl">About Sources</h4>
        <div class="w-full flex flex-row flex-wrap">
          <div class="lg:w-1/5 h-full p-4">
            <div class="bg-yellow-400 text-white p-4 rounded-xl shadow-md">
              <b>Basic Oscillator</b>
              <p class="text-sm">This sound source has 3 waveforms (Sine, Square, and Triangle) that you can fade between.</p>
            </div>
          </div>

          <div class="lg:w-1/5 h-full p-4">
            <div class="bg-yellow-400 text-white p-4 rounded-xl shadow-md">
              <b>WaveShaper</b>
              <p class="text-sm">WaveShaper adds sine waves together to create rich additive sounds.</p>
            </div>
          </div>

          <div class="lg:w-1/5 p-4">
            <div class="bg-yellow-400 text-white p-4 rounded-xl shadow-md">
              <b>Tensions</b>
              <p class="text-sm">A physical modeling instrument with positive feedback, that can be used to create all sorts of string sounds.</p>
            </div>
          </div>

          <div class="lg:w-1/5 p-4">
            <div class="bg-yellow-400 text-white p-4 rounded-xl shadow-md">
              <b>Sampler</b>
              <p class="text-sm">With Sampler, you can load your own sampled sounds into Donut and play them like an instrument!</p>
            </div>
          </div>

          <div class="lg:w-1/5 p-4">
            <div class="bg-yellow-400 text-white p-4 rounded-xl shadow-md">
              <b>Particles</b>
              <p class="text-sm">Particles is a granular sound engine that granulates prerecorded samples. It comes with a suite of playback options to apply to this process.</p>
            </div>
          </div>
        </div>

        <div class="lg:w-2/3 mb-4">
          <h4 class="font-bold text-xl">About Parameters</h4>
          <p>Donut implements a global parameter system that makes sure values are synchronized between all different parts of the synthesizer. Settings are stored in a central storage class, which is then available to all other system components. This allows preset loading to be as seamless as it is, and gives the entire application access to all the values it might need.</p>
        </div>

        <h4 class="font-bold text-xl">About Modulators</h4>
        <div class="w-full flex flex-row flex-wrap">
          <div class="lg:w-1/4 p-4">
            <div class="bg-red-400 text-white p-4 rounded-xl shadow-md">
              <b>LFO</b>
              <p class="text-sm">A basic oscillator that outputs a slow sine wave for use in modulation.</p>
            </div>
          </div>

          <div class="lg:w-1/4 p-4">
            <div class="bg-red-400 text-white p-4 rounded-xl shadow-md">
              <b>ADSR</b>
              <p class="text-sm">An envelope generator with Attack, Decay, Sustain, and Release phases. Note velocity is mapped to the sustain level of this modulator by default.</p>
            </div>
          </div>

          <div class="lg:w-1/4 p-4">
            <div class="bg-red-400 text-white p-4 rounded-xl shadow-md">
              <b>Random</b>
              <p class="text-sm">Generates random numbers for use in modulation. You can control the interval at which new numbers are generated, and a slew can be applied for smoother output.</p>
            </div>
          </div>

          <div class="lg:w-1/4 p-4">
            <div class="bg-red-400 text-white p-4 rounded-xl shadow-md">
              <b><span class="text-red-100">[Future]</span> Sequencer</b>
              <p class="text-sm">A global sequencer that can be synced to note input, turning it into a sort of arpeggiator.</p>
            </div>
          </div>
        </div>

        <div class="lg:w-2/3 mb-4">
          <h4 class="font-bold text-xl">About Presets and Maps</h4>
          <p>In Donut, it's possible to save almost all user settings as presets or controller maps.<br>
             Presets are used to store values that are contained in the central parameter pool, and are recalled easily. It's also possible to load external saves by putting them into the <code>.donut_runtime</code> directory. This is also where controller maps are stored, which contain mappings for MIDI controllers. These can be exported from the command line interface, an implementation for the GUI is still in the works.</p>
        </div>

        <h4 class="font-bold text-xl">About Effects</h4>
        <div class="w-full flex flex-row flex-wrap">
          <div class="lg:w-1/4 p-4">
            <div class="bg-lime-500 text-white p-4 rounded-xl shadow-md">
              <b>Stereo Delay</b>
              <p class="text-sm">A two-channel delay effect on the master output, with a maximum delay time of 1000ms.</p>
            </div>
          </div>

          <div class="lg:w-1/4 p-4">
            <div class="bg-lime-500 text-white p-4 rounded-xl shadow-md">
              <b><span class="text-lime-100">[Future]</span> Wave folder</b>
              <p class="text-sm">A distortion effect that applies a gain to the input sound wave and then folds it back on itself.</p>
            </div>
          </div>

          <div class="lg:w-1/4 p-4">
            <div class="bg-lime-500 text-white p-4 rounded-xl shadow-md">
              <b><span class="text-lime-100">[Future]</span> Reverb</b>
              <p class="text-sm">A rich reverb effect, based on the classic Schroeder reverb algorithm.</p>
            </div>
          </div>

          <div class="lg:w-1/4 p-4">
            <div class="bg-lime-500 text-white p-4 rounded-xl shadow-md">
              <b><span class="text-lime-100">[Future]</span> Glitch</b>
              <p class="text-sm">A modern glitch engine, applying various glitches (reverse, stutter, bit crush) to the output sound.</p>
            </div>
          </div>
        </div>

        <div class="lg:w-2/3 mb-4">
          <h4 class="font-bold text-xl">About connecting all of these together</h4>
          <p>All these systems and modules are interconnected through a few key services components: Presets, Parameters, Modulation Matrix, and Control Map. The current system design looks something like this:</p>
        </div>
        <img src="/img/donut_diagram.png" alt="">
      </div>
    </div>


    <div class="w-full lg:w-2/3 mx-auto p-8">
      <div id="demo-patches">
        <h1 class="font-bold text-4xl mb-4">...and what can it do?</h1>
        <div class="xl:w-4/5 mx-auto">
          <div class="video-container">
            <iframe src="https://www.youtube.com/embed/l_BN0GC_peM" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          <span class="text-sm italic text-gray-400">A lot, apparently...</span>
        </div>

        <div id="patchIdeas">
          <p class="lg:w-2/3">Using the modulation matrix and parameter pool, it's possible to make a lot of interesting patches using Donut. The possibilities are almost endless, but here are some examples that might result in an interesting sonic palette.</p>

          <div class="w-full lg:flex lg:flex-row">
            <div class="p-4 w-full lg:w-1/2">
              <div class="p-4 bg-yellow-400 rounded-xl shadow-md">
                <h4 class="text-lg font-semibold text-yellow-100">Patch #1 <span class="text-white font-bold">Feedback Strings</span></h4>
                <p class="text-sm"></p>
              </div>
            </div>

            <div class="p-4 w-full lg:w-1/2">
              <div class="p-4 bg-yellow-400 rounded-xl shadow-md">
                <h4 class="text-lg font-semibold text-yellow-100">Patch #2 <span class="text-white font-bold">Random Harmonics</span></h4>
                <p class="text-sm"></p>
              </div>
            </div>
          </div>

          <div class="w-full lg:flex lg:flex-row">
            <div class="p-4 w-full lg:w-1/2">
              <div class="p-4 bg-yellow-400 rounded-xl shadow-md">
                <h4 class="text-lg font-semibold text-yellow-100">Patch #3 <span class="text-white font-bold">...</span></h4>
                <p class="text-sm"></p>
              </div>
            </div>

            <div class="p-4 w-full lg:w-1/2">
              <div class="p-4 bg-yellow-400 rounded-xl shadow-md">
                <h4 class="text-lg font-semibold text-yellow-100">Patch #4 <span class="text-white font-bold">...</span></h4>
                <p class="text-sm"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full lg:w-2/3 mx-auto p-8 mb-8">
      <div id="build-instructions">
        <h1 class="font-bold text-4xl mb-4">That's amazing, where can I get it?</h1>
        <div class="lg:w-2/3">
          <p class="mb-2">Now hold on to your horses. This project is still in active development, and there are currently no production builds available. However, if you're crazy enough, you can <i>attempt</i> to build it yourself, for which I made build targets for <b>macOS</b> and <b>Linux</b>.</p>
          <p class="text-sm text-yellow-600 mb-6"><b>Please note</b> that I do <b>not</b> provide tech support, and building Donut from source code is completely at your own risk. If you discover a bug (of which there are <i>plenty</i>), please open an issue on GitHub. If you can think of a solution, feel free to create a pull request too!</p>


          <div class="mb-4" id="tutorial-step-1">
            <h4 class="text-xl font-semibold"><span class="font-bold text-yellow-600 mr-4">Step 1</span> getting Donut and Dependencies</h4>
            <div class="flex flex-row items-center mb-2">
              <h6 class="flex-auto text-sm font-semibold text-gray-500">Difficulty level: <span class="text-pink-600">2 sprinkles</span></h6>

              <select class="font-bold text-yellow-500" v-model="selected_platform">
                <option v-for="platform in platforms" :key="platform" :value="platform">{{platform}}</option>
              </select>
            </div>

            <p>This first step involves Git and your package manager of choice. On macOS I use Homebrew and on Linux I use <code>apt</code>. For a start, let's download the source code of Donut. This can be done using Git:<br>
              <codebox>
                <span class="select-none">$ </span><span>git pull https://github.com/layetri/donut.git</span><br>
                <span class="select-none">$ </span><span>cd donut</span>
              </codebox>
            </p>

            <div class="bg-yellow-400 text-white p-4 rounded-xl shadow-md my-4" v-if="selected_platform === 'Linux'">
              <b>Linux tip</b>
              <p class="text-sm">You can easily install all necessary build tools using the following line:
                <codebox>
                  <span class="select-none">$ </span><span>sudo apt install git cmake build-essential</span>
                </codebox>
              </p>
              <p class="text-sm">On systems without a desktop environment, run this command to install the X display server:
                <codebox>
                  <span class="select-none">$ </span><span>sudo apt install xserver-xorg xinit x11-xserver-utils</span>
                </codebox>
              </p>
            </div>

            <p>Now that you have obtained the source code, let's install its dependencies. The requirements are different between macOS and Linux, so make sure you select the right platform. <span v-if="selected_platform === 'macOS'">Besides installing dependencies through your package manager, make sure you have installed the <a href="https://jackaudio.org">JACK Audio Connection Kit</a> from their website.</span></p>
            <codebox v-if="selected_platform === 'macOS'">
              <span class="select-none">$ </span><span>brew install libjack-jackd2-dev</span>
            </codebox>
            <codebox v-else-if="selected_platform === 'Linux'">
              <span class="select-none">$ </span><span>sudo apt install jackd2 libjack-jackd2-0 libjack-jackd2-dev libglfw3 libglfw3-dev libncurses5-dev mesa-utils libglu1-mesa-dev mesa-common-dev</span>
            </codebox>
          </div>

          <div class="mb-4" id="tutorial-step-2">
            <h4 class="text-xl font-semibold"><span class="font-bold text-yellow-600 mr-4">Step 2</span> building Donut</h4>
            <h6 class="flex-auto text-sm font-semibold text-gray-500">Difficulty level: <span class="text-pink-600">2 sprinkles</span></h6>

            <p>After collecting all the dependencies, it's time to look at the building process itself. Donut uses CMake to generate its build files. For the build process, I use <code>clang</code> on macOS and <code>gcc</code> on Linux. If you haven't installed these yet, you should do it now.<br>
              First, we can generate the build files like this:</p>
            <codebox>
              <span class="select-none">$ </span><span>cmake .</span>
            </codebox>
            <p>With these build files, we can create the application binary.</p>
            <codebox>
              <span class="select-none">$ </span><span>make</span>
            </codebox>
            <p>Congratulations, you've just obtained yourself a Donut executable!</p>
          </div>

          <div id="tutorial-step-3">
            <h4 class="text-xl font-semibold"><span class="font-bold text-yellow-600 mr-4">Step 3</span> running Donut</h4>
            <div class="flex flex-row items-center mb-2">
              <h6 class="flex-auto text-sm font-semibold text-gray-500">Difficulty level: <span class="text-pink-600">1 sprinkle</span></h6>

              <select class="font-bold text-yellow-500" v-model="selected_platform">
                <option v-for="platform in platforms" :key="platform" :value="platform">{{platform}}</option>
              </select>
            </div>

            <p>To run Donut, it is important that JACK is running. On Linux, it's also recommended to use a MIDI bridge like <code>a2jmidid</code>. Donut runs the best with a JACK setup like this:</p>
            <codebox v-if="selected_platform === 'macOS'">
              <span class="select-none">$ </span><span>jackd -d coreaudio -p 512 -r 44100</span>
            </codebox>
            <codebox v-else-if="selected_platform === 'Linux'">
              <span class="select-none">$ </span><span>jackd -d alsa -p 512 -r 44100</span>
            </codebox>
            <p>Then, you can run Donut! Make sure to run it from the project root folder, like this:</p>
            <codebox v-if="selected_platform === 'macOS'">
              # Questionable if this works, depends on build setup<br>
              # This one's for Clion builds:<br>
              <span class="select-none">$ </span><span>./cmake-build-debug/donut</span>
            </codebox>
            <codebox v-else-if="selected_platform === 'Linux'">
              <span class="select-none">$ </span><span>./donut</span>
            </codebox>
          </div>
        </div>
      </div>
    </div>
    
    <div class="w-full lg:w-2/3 mx-auto p-8 mb-8">
      <div id="faq">
        <h1 class="font-bold text-4xl mb-4">How do I...</h1>
        <div class="flex flex-row">
          <div class="lg:w-1/3 p-4">
            <h4 class="text-xl font-bold mb-4">...load presets?</h4>
            <img src="/img/donut_where_presets_go.png" class="w-2/3 mx-auto bg-gray-100 p-4 rounded-xl mb-4" alt="">
            <p class="mb-4">To load <code>.donutpreset</code> files from external sources into Donut, you can put them into the <b>presets</b> folder, found in <b><code>path_to_donut</code>/.donut_runtime</b>.</p>

          </div>
        </div>
      </div>
    </div>
    
    <div class="w-full lg:w-2/3 mx-auto p-8 mb-8">
      <div id="codeOnGithub">
        <div class="lg:w-2/5 w-full mx-auto">
          <div class="absolute w-4/5 lg:w-1/4 z-10 absCenter">
            <img src="/img/donut_code.png" class="z-10" alt="">
            <div class="absolute w-full z-20">
              <div class="bg-gray-900 text-gray-100 cursor-pointer w-max p-2 px-8 text-center text-xs rounded-xl mx-auto shadow-lg" @click="openGithub()" style="margin-top: -3rem;">
                the code is on<br>
                <span class="text-xl font-bold text-white">github</span>
              </div>
            </div>
          </div>
          <div class="absolute w-full left-0 bg-yellow-400 z-0 pb-10" style="margin-top: 10rem; padding-top: 15rem;">
            <div class="w-3/5 mx-auto">
              <div class="lg:flex lg:flex-row mb-6">
                <div class="lg:w-1/3 p-4">
                  <h4 class="font-bold text-xl">Disclaimer</h4>
                  <p class="text-gray-800 text-sm">Everything on this page was developed and designed by me. I did, however, use some third party libraries. This website runs on Laravel, and uses VueJS and TailwindCSS as well. For any info on open source code used for Donut, please check the GitHub repository.</p>
                </div>

                <div class="lg:w-1/3 p-4">
                  <h4 class="font-bold text-xl">Notes</h4>
                  <p class="text-gray-800 text-sm">This project is under active development. Any features listed on this page may be changed or removed at any time, and this website may not reflect the current state of the software. For an up-to-date overview, check the GitHub repository.</p>
                </div>

                <div class="lg:w-1/3 p-4">
                  <h4 class="font-bold text-xl">Note for pros</h4>
                  <p class="text-gray-800">Are you looking to hire an audio/music dev with experience in a broad range of programming applications? Check out my full portfolio on <a
                      href="/projects" class="underline font-bold text-pink-600">layetri.net</a>!</p>
                </div>
              </div>

              <div class="text-center text-sm text-gray-600">
                Copyright &copy; {{new Date().getFullYear()}} Layetri. All rights reserved.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Main",
  data() {
    return {
      platforms: ["macOS", "Linux"],
      selected_platform: "macOS"
    }
  },
  methods: {
    openGithub() {
      window.open("https://github.com/layetri/donut", '_blank').focus();
    }
  }
}
</script>

<style scoped>
  #donutHeader {
    background-image: url("/img/donut_header.jpg");
    background-size: cover;
    background-position: center;
  }

  .video-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 */
    height: 0;
  }
  .video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  .absCenter {
    left: 50%;
    transform: translate(-50%, 0);
  }

  code {
    font-size: 0.8rem;
    @apply bg-gray-200 rounded px-1 text-pink-500;
  }

  a {
    @apply font-bold text-pink-600 underline;
  }

  codebox {
    @apply bg-yellow-50 rounded-lg px-4 py-2 my-2 font-mono text-sm text-gray-600 w-full block;
  }
  codebox span {
    @apply select-all;
  }
</style>