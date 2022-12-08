<template>
  <div id="projectView">
    <div class="p-4">
      <small class="text-xs text-gray-500 uppercase">
        <a href="/projects">projects</a> &raquo; <a href="">{{ project.href }}</a>
      </small>
      <h1 class="text-4xl font-bold">{{ project.name }}</h1>
    </div>

    <div class="flex flex-col-reverse lg:flex-row">
      <div class="w-full lg:w-1/2 p-4 layoutEngine">
        <div v-if="project.description !== project.name">
          <div id="projectDescription" class="text-sm italic" v-html="project.description"></div>
          <br>
        </div>
        <div v-for="el in content" v-html="el"></div>
      </div>

      <div class="w-full lg:w-1/2 p-4">
        <div class="w-full">
          <img class="shadow-lg rounded-lg border-4 border-white" :src="project.image" :alt="project.name">
        </div>

        <div class="flex flex-row p-2 md:p-6 mt-4 tracking-wider">
          <div class="flex-auto text-center" v-if="project.project_url !== null">
            <a class="px-2 sm:px-4 xl:px-8 py-2 border-2 border-teal-400 text-teal-500 rounded-xl bg-white hover:bg-teal-100 uppercase text-xs" target="_blank" :href="project.project_url">
              <i class="fa fa-play mr-2"></i>
              <span class="text-gray-500">start</span>
            </a>
          </div>
          <div class="flex-auto text-center" v-if="project.youtube !== null">
            <a class="px-2 sm:px-4 xl:px-8 py-2 border-2 border-red-400 text-red-500 rounded-xl bg-white hover:bg-red-100 uppercase text-xs" target="_blank" :href="'https://youtube.com/watch?v='+project.youtube">
              <i class="fab fa-youtube mr-2"></i>
              <span class="text-gray-500">youtube</span>
            </a>
          </div>
          <div class="flex-auto text-center" v-if="project.github !== null">
            <a class="px-2 sm:px-4 xl:px-8 py-2 border-2 border-gray-400 text-gray-600 rounded-xl bg-white hover:bg-gray-200 uppercase text-xs" target="_blank" :href="'https://github.com/'+project.github">
              <i class="fab fa-github mr-2"></i>
              <span class="text-gray-500">github</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import edjsHTML from 'editorjs-html';

  export default {
    name: "ProjectPage",
    props: {
      pid: String
    },
    data() {
      return {
        project: {},
        content: [],
        parser: new edjsHTML({alert: this.parseAlert})
      }
    },
    created() {
      console.log(this.pid);
      axios.get('/fetch/project/'+this.pid).then(res => {
        this.project = res.data;
        document.title = this.project.name;

        this.content = this.parser.parse(JSON.parse(this.project.content));
      });
    },
    methods: {
      parseAlert(block){
        return '<div class="alert alert-'+ block.data.type +'">' + block.data.message + '</div>';
      }
    }
  }
</script>

<style>
  .alert {
    @apply py-2 px-4 border rounded-lg;
  }

  .alert-primary {
    @apply bg-teal-50 border-teal-400 text-teal-600;
  }
  .alert-secondary {
    @apply bg-gray-50 border-gray-400 text-gray-600;
  }
  .alert-info {
    @apply bg-blue-50 border-blue-400 text-blue-600;
  }
  .alert-success {
    @apply bg-green-50 border-green-400 text-green-600;
  }
  .alert-warning {
    @apply bg-orange-50 border-orange-400 text-orange-600;
  }
  .alert-danger {
    @apply bg-red-50 border-red-400 text-red-600;
  }
</style>