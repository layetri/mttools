<template>
  <div class="w-full">
    <h2 class="font-bold text-xl mb-2">Featured</h2>

    <div class="flex w-full h-full">
      <div class="w-1/2 h-full p-2" v-for="project in projects">
        <div class="rounded-xl shadow-xl h-full w-full bg-cover bg-center bg-no-repeat p-4 flex flex-col" :style="{backgroundImage: 'url('+project.image+')'}">
          <h2 class="text-white font-bold text-2xl filter drop-shadow">{{project.name}}</h2>
          <project-type :type="project.label"></project-type>

          <div class="flex-auto"></div>

          <a :href="'/projects/'+project.href" class="px-2 sm:px-4 xl:px-8 py-2 border-2 border-teal-400 text-teal-500 rounded-xl bg-white hover:bg-teal-100 bg-opacity-80 uppercase text-xs w-max mx-auto cursor-pointer shadow">Read more</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "FeaturedWorks",
    data() {
      return {
        projects: []
      }
    },
    created() {
      axios.get('fetch/projects/featured').then(res => {
        this.projects = res.data;
      });
    }
  }
</script>

<style scoped>

</style>