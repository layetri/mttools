<template>
  <div>
    <div class="grid grid-cols-3 gap-6">
      <div v-for="project in projects">
        <div class="bg-white rounded-xl shadow-lg cursor-pointer" @click="visit(project.href)">
          <img :src="project.image" alt="">
          <div class="p-4">
            <h2 class="text-xl font-bold">{{project.name}}</h2>
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