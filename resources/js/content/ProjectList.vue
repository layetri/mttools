<template>
  <div>
    <div class="md:flex content-center flex-wrap">
      <div v-for="project in projects" class="md:flex w-full px-2 py-2"
           :class="[project.highlight ? 'md:w-2/3 lg:w-2/4' : 'md:w-1/3 lg:w-1/4']">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg cursor-pointer" @click="visit(project.href)" v-if="!project.highlight">
          <img :src="project.image" class="rounded-t-xl" alt="">
          <div class="p-4 flex flex-col">
            <h2 class="text-xl font-bold flex-grow-0">{{project.name}}</h2>

            <div class="flex-auto"></div>

            <div class="mt-4">
              <project-type :type="project.label"></project-type>
            </div>
          </div>
        </div>

        <div class="rounded-xl shadow-lg flex w-full bg-teal-50 dark:bg-teal-900" v-else>
          <div class="w-1/2 p-4 flex flex-col">
            <h2 class="text-3xl font-bold flex-grow-0">{{project.name}}</h2>

            <div class="flex-auto">
              <p class="text-md italic text-gray-600 dark:text-gray-200">
                <span v-for="(letter, i) in project.description" v-if="i < 100">{{letter}}</span>...
              </p>
            </div>

            <div class="mt-4">
              <project-type :type="project.label"></project-type>
            </div>
          </div>
          <div class="w-1/2 h-full bg-center bg-no-repeat bg-cover rounded-r-xl" :style="{backgroundImage: 'url('+project.image+')'}">
            <div class="h-full flex flex-col p-4 text-center">
              <div class="flex-auto"></div>
              <span class="px-2 sm:px-4 xl:px-8 py-2 border-2 border-teal-400 text-teal-500 rounded-xl bg-white hover:bg-teal-100 uppercase text-xs w-1/2 mx-auto cursor-pointer" @click="visit(project.href)">Read more</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "ProjectList",
    data() {
      return {
        exps: [
            {url: 'roll', name: 'r0LL (SYSBAS Eindopdracht 19-20)', type: ['assignment', 'blue'], lang: ['P5js', 'pink']},
            {url: 'ko2a-1', name: 'KO2a MakerSkill 1: Live Looping', type: ['assignment', 'blue'], lang: ['tonejs', 'teal']},
            {url: 'ko2a-2', name: 'KO2a MakerSkill 2: Complex Delay', type: ['assignment', 'blue'], lang: ['tonejs', 'teal']},
          {url: 'ko2a-3', name: 'KO2a MakerSkill 3: Granular Effect', type: ['assignment', 'blue'], lang: ['tonejs', 'teal']},
            //{url: '', name: '', type: ['', ''], lang: ['', '']},
        ],
        projects: []
      }
    },
    created() {
      axios.get('/fetch/projects').then(res => {
        this.projects = res.data;
      });
    },
    methods: {
      visit(href) {
        location.href = 'projects/' + href;
      }
    }
  }
</script>

<style scoped>

</style>