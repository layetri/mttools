<template>
  <div>
    <button @click="$emit('open-editor')" class="font-bold text-teal-500 uppercase text-sm mb-4">Edit</button>
    <div class="layoutEngine">
      <div v-for="el in content" v-html="el"></div>
    </div>
  </div>
</template>

<script>
  import edjsHTML from 'editorjs-html';

  export default {
    name: "PortfolioViewer",
    props: {
      article: Object
    },
    data() {
      return {
        parser: new edjsHTML({alert: this.parseAlert}),
        content: ''
      }
    },
    methods: {
      parseAlert(block){
        return '<div class="alert alert-'+ block.data.type +'">' + block.data.message + '</div>';
      }
    },
    watch: {
      article() {
        if(this.article.content) {
          this.content = this.parser.parse(JSON.parse(this.article.content));
        } else {
          this.content = [];
        }
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