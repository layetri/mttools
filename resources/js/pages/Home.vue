<template>
  <div class="overflow-x-hidden">
    <div class="absolute top-0 h-screen w-full overflow-hidden">
      <div class="fixed bg-whiteboard"></div>
    </div>
    <div class="lg:p-16 p-8 absolute min-h-screen top-0">
      <div class="flex flex-row w-full">
        <div class="xl:w-1/3 md:w-1/2 w-full bg-white lg:p-8 p-4 rounded-xl shadow-lg">
          <h1 class="font-serif text-5xl font-bold mb-2">Hi, I'm Layetri!</h1>
          <p class="mb-4">I'm a music technology student at HKU University for the Arts Utrecht, and founder and lead developer at <a href="https://expressivelabs.net" class="hover:underline text-teal-500">ExpressiveLabs</a>. As an audio developer, my main focus is on sound synthesis, specifically the generation of humanlike voices. I work with a dedicated team to create the next generation of singing voice synthesis software, Mikoto Studio.</p>

          <p class="mb-8">Besides singing synthesis, I also have an affinity for analog synths and anything with keys. I built a <a href="/whats-in-my-rack" class="hover:underline text-teal-500">DIY modular synthesizer</a> as a hobby project, and I created <a href="/donut" class="hover:underline text-teal-500">Donut</a> as my third-year university project. I play piano and (bass) guitar, and I produce songs using vocal synthesis software.</p>

          <div>
            <div class="text-bold text-gray-600 dark:text-gray-300 uppercase tracking-wide mb-2">
              <small>Connect with me</small>
            </div>

            <div class="flex inline-flex w-full text-center text-gray-400 select-none">
              <div class="flex-auto hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer">
                <a href="https://github.com/layetri" target="_blank">
                  <i class="fab text-black dark:text-white text-2xl fa-github mb-1"></i><br>
                  <small class="uppercase tracking-wide text-xs">layetri</small>
                </a>
              </div>

              <div class="flex-auto hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer">
                <a href="https://soundcloud.com/layetri" target="_blank">
                  <i class="fab text-orange-500 text-2xl fa-soundcloud mb-1"></i><br>
                  <small class="uppercase tracking-wide text-xs">layetri</small>
                </a>
              </div>

              <div class="flex-auto hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer">
                <a href="https://twitter.com/layetri_p" target="_blank">
                  <i class="fab text-blue-400 text-2xl fa-twitter mb-1"></i><br>
                  <small class="uppercase tracking-wide text-xs">layetri_p</small>
                </a>
              </div>
            </div>

            <div class="p-3">
              <hr>
            </div>

            <div class="text-bold text-gray-600 dark:text-gray-300 uppercase tracking-wide w-full flex">
              <small class="flex-auto">Tools & Skills</small>
              <small class="text-xs text-teal-400">
                <a href="https://stackshare.io/layetri">View full stack</a>
              </small>
            </div>

            <div class="mx-auto py-3">
              <div class="grid grid-cols-3 lg:grid-cols-6 gap-2 w-full text-center text-gray-400 cursor-default select-none">
                <div class="text-center hover:text-gray-600 dark:hover:text-gray-200">
                  <i class="devicon-laravel-plain text-red-400 text-2xl mb-2"></i><br>
                  <small class="uppercase tracking-wide text-xs">Laravel</small>
                </div>
                <div class="text-center hover:text-gray-600 dark:hover:text-gray-200">
                  <i class="devicon-vuejs-plain text-teal-400 text-2xl mb-2"></i><br>
                  <small class="uppercase tracking-wide text-xs">Vue</small>
                </div>
                <div class="text-center hover:text-gray-600 dark:hover:text-gray-200">
                  <i class="devicon-cplusplus-plain text-blue-500 text-2xl mb-2"></i><br>
                  <small class="uppercase tracking-wide text-xs">C++</small>
                </div>
                <div class="text-center hover:text-gray-600 dark:hover:text-gray-200">
                  <i class="devicon-python-plain text-yellow-300 text-2xl mb-2"></i><br>
                  <small class="uppercase tracking-wide text-xs">Python</small>
                </div>
                <div class="text-center hover:text-gray-600 dark:hover:text-gray-200">
                  <i class="devicon-rust-plain text-gray-700 text-2xl mb-2"></i><br>
                  <small class="uppercase tracking-wide text-xs">Rust</small>
                </div>
                <div class="text-center hover:text-gray-600 dark:hover:text-gray-200">
                  <i class="devicon-git-plain text-orange-500 text-2xl mb-2"></i><br>
                  <small class="uppercase tracking-wide text-xs">Git</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="flex-auto"></div>
      </div>
    </div>

    <div class="bg-gray-100 min-h-screen w-screen absolute z-10" style="margin-top: 100vh">
      <div class="flex flex-row">
        <div class="p-16 flex-auto">
          <div class="mb-8 md:w-1/2">
            <h1 class="text-4xl font-bold font-serif mb-2">Layetri in the real world</h1>
            <p class="text-gray-700">Every now and then, I speak at public and private events about the things I make. Here are a few of them, along with some projects that I have recently worked on.</p>
          </div>

          <div class="mb-8">
            <h3 class="text-2xl font-bold font-serif mb-2">Events</h3>

            <div class="grid md:grid-cols-4 grid-cols-1 gap-4">
              <div class="bg-white rounded-md shadow p-4" v-for="event in events">
                <p class="font-bold">{{ event.name }}</p>
                <p class="text-xs text-gray-400 capitalize mb-2">{{ event.role }}</p>

                <a :href="event.url" target="_blank" class="text-xs text-teal-500 hover:underline">Event website</a>
              </div>
            </div>
          </div>

          <div class="mb-8">
            <h3 class="text-2xl font-bold font-serif mb-2">Projects</h3>

            <div class="grid md:grid-cols-4 grid-cols-1 gap-4">
              <div class="bg-white rounded-md shadow" v-for="project in projects">
                <div class="h-16 bg-center bg-cover rounded-t-md" :style="{backgroundImage: 'url('+project.image+')'}"></div>

                <div class="p-4">
                  <p class="font-bold">{{ project.name }}</p>
                  <p class="text-xs text-gray-400 capitalize mb-2">{{ project.role }}</p>

                  <p class="text-xs text-gray-600 mb-4">{{project.info}}</p>

                  <a :href="project.url" target="_blank" class="text-xs text-teal-500 hover:underline">Project website</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="md:w-1/3 hidden md:block min-h-screen bg-notn flex-shrink-0">
<!--          <div class="bg-notn"></div>-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        events: [
          {'name': 'HKU Exposure 2023', 'url': 'https://exposure.hku.nl/p/mikoto-studio-1', 'role': 'speaker', 'info': ''},
          {'name': 'Night of the Nerds 2023', 'url': 'https://www.nightofthenerds.com/portfolio/ontdek-en-speel-met-een-ai/', 'role': 'booth, speaker', 'info': ''},
          {'name': 'Private Kitchen Live', 'url': 'https://www.privatekitchen.nl/articles/exposure-2023', 'role': 'speaker', 'info': '(Part of HKU Exposure)'}
        ],
        projects: [
          {'name': 'Mikoto Studio', 'info': 'A new singing synthesizer using AI and concatenative technologies', 'url': 'https://mikoto.studio', 'role': 'Project lead', 'image': '/img/mikoto.png'},
          {'name': 'Sayaka AI', 'info': 'Multilingual neural voice library for Mikoto Studio', 'url': 'https://mikoto.studio', 'role': 'Director, producer', 'image': '/img/sayaka.jpeg'},
          {'name': 'Jinshi AI', 'info': 'Multilingual neural voice library for Mikoto Studio', 'url': 'https://mikoto.studio/', 'role': 'Director, producer', 'image': '/img/jinshi.jpeg'},
          {'name': 'Donut', 'info': 'Open-source 12-voice digital polyphonic synthesizer', 'url': '/donut', 'role': 'Developer', 'image': '/img/donut_header.jpg'},
          // {'name': '', 'info': '', 'url': '', 'role': '', 'image': ''},
        ]
      }
    }
  }
</script>

<style scoped>
  .bg-whiteboard {
    width: calc(100vw + 20px);
    height: calc(100vh + 20px);
    top: -10px;
    left: -10px;
    background-image: url('/img/whiteboar.jpeg');
    background-size: cover;
    background-position: center;
    filter: blur(5px);
  }

  .bg-notn {
    background-image: url("/img/notn.jpeg");
    background-size: auto 100vh;
    background-repeat: no-repeat;
    background-position: right;
    background-attachment: fixed;
  }
</style>