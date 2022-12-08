<template>
  <div class="w-full h-full flex flex-row">
    <div class="w-1/5 border-r dark:border-gray-600 flex-shrink-0">
      <div class="px-4 m-4 py-2 rounded-lg bg-teal-500 text-white font-bold tracking-wider uppercase cursor-pointer shadow text-sm text-center" @click="[create = true, edit = false]">
        create
      </div>

      <div class="px-4 py-2 m-2 border rounded-lg shadow cursor-pointer" @click="[selected = projects.indexOf(item), create = false]" :class="[selected === projects.indexOf(item) ? 'bg-gray-200 dark:bg-gray-700 border-teal-500' : 'bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400']" v-for="item in projects">
        {{item.name}}
      </div>
    </div>
    <div class="flex-auto p-4">
      <admin-editor :article_id="projects.length > 0 ? projects[selected].href : undefined" :action="edit ? 'edit' : 'create'" v-if="edit || create" @close-editor="[edit = false, create = false]"></admin-editor>

      <admin-portfolio-viewer :article="projects[selected]" v-else-if="projects.length > 0" @open-editor="edit = true"></admin-portfolio-viewer>
    </div>
  </div>
</template>

<script>
  export default {
    name: "portfolio",
    props: {
      user: Object
    },
    data() {
      return {
        projects: [],
        selected: 0,
        edit: false,
        create: false
      }
    },
    created() {
      axios.get('/fetch/projects').then(res => {
        this.projects = res.data;
      });
    }
  }
</script>

<style scoped>

</style>