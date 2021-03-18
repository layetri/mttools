<template>
  <div id="projectView">
    <div class="p-4">
      <small class="text-xs text-gray-500 uppercase">
        <a href="/projects">projects</a> &raquo; <a href="">{{ project.href }}</a>
      </small>
      <h1 class="text-4xl font-bold">{{ project.name }}</h1>
    </div>

    <div class="flex flex-row">
      <div class="w-1/2 p-4">
        <div id="projectDescription" v-html="project.description"></div>
      </div>

      <div class="w-1/2 p-4">
        <div class="w-full">
          <img class="shadow-lg rounded-lg border-4 border-white" :src="project.image" :alt="project.name">
        </div>

        <div class="flex flex-row p-6 mt-4">
          <div class="flex-auto text-center" v-if="project.project_url !== null">
            <a class="px-8 py-2 font-light border-2 border-teal-500 text-teal-500 rounded-xl bg-white hover:bg-teal-100" :href="project.project_url">start</a>
          </div>
          <div class="flex-auto text-center" v-if="project.youtube !== null">
            <a class="px-8 py-2 font-light border-2 border-red-500 text-red-500 rounded-xl bg-white hover:bg-red-100" :href="'https://youtube.com/watch?v='+project.youtube">youtube</a>
          </div>
          <div class="flex-auto text-center" v-if="project.github !== null">
            <a class="px-8 py-2 font-light border-2 border-gray-700 text-gray-700 rounded-xl bg-white hover:bg-gray-100" :href="'https://github.com/'+project.github">github</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "ProjectPage",
    props: {
      pid: String
    },
    data() {
      return {
        project: {}
      }
    },
    created() {
      console.log(this.pid);
      axios.get('/fetch/project/'+this.pid).then(res => {
        this.project = res.data;
        document.title = this.project.name;
      });
    }
  }
</script>

<style scoped>

</style>