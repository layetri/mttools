<template>
  <div>
    <div class="w-full flex flex-row p-4">
      <div class="text-uppercase text-gray-400 text-sm tracking-widest uppercase">
        Portfolio editor
      </div>
      <div class="flex-auto"></div>
      <div>
        <button class="mr-4 text-gray-500 font-bold uppercase bg-white dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-50 px-4 py-1 rounded shadow text-xs" @click="$emit('close-editor')">cancel</button>
        <button class="text-white font-bold uppercase bg-teal-500 hover:bg-teal-700 px-4 py-1 rounded shadow text-xs" @click="storeEdits">save</button>
      </div>
    </div>

    <div>
      <input class="text-2xl mb-4 w-full py-2 px-6 rounded-xl dark:bg-gray-700" type="text" placeholder="Title" v-model="article.name">
    </div>

    <div class="w-full bg-white dark:bg-gray-700 my-4 p-6 rounded-xl text-center text-gray-400 dropzone cursor-pointer" @drop.prevent="handleDrop" @dragover.prevent @click="fileDialog">
        <input type="file" id="dropzone" @change="handleDrop" hidden>
        Drop image here
    </div>



    <div class="grid grid-cols-3 mb-4">
      <div class="p-4 pl-0 w-full rounded-xl flex flex-row">
        <div class="w-1/6 bg-teal-400 rounded-l-xl h-full"></div>
        <input class="flex-auto dark:bg-gray-700 py-2 px-6 rounded-r-xl" type="text" placeholder="Project URL" v-model="article.project_url">
      </div>
      <div class="p-4 w-full rounded-xl flex flex-row">
        <div class="w-1/6 bg-gray-700 rounded-l-xl h-full"></div>
        <input class="flex-auto dark:bg-gray-700 py-2 px-6 rounded-r-xl" type="text" placeholder="GitHub" v-model="article.github">
      </div>
      <div class="p-4 pr-0 w-full rounded-xl flex flex-row">
        <div class="w-1/6 bg-red-400 rounded-l-xl h-full"></div>
        <input class="flex-auto dark:bg-gray-700 py-2 px-6 rounded-r-xl" type="text" placeholder="YouTube" v-model="article.youtube">
      </div>
    </div>

    <div class="mb-4 layoutEngine">
      <div class="w-full bg-white dark:bg-gray-700 rounded-xl p-4" id="editor"></div>
    </div>

    <div class="grid grid-cols-2 mb-10">
      <div class="p-4 pl-0 w-full rounded-xl flex flex-row">
        <div class="w-1/6 bg-gray-200 rounded-l-xl h-full"></div>
        <input class="flex-auto dark:bg-gray-700 py-2 px-6 rounded-r-xl" type="text" placeholder="Label" v-model="article.label">
      </div>
      <div class="p-4 pr-0 w-full rounded-xl flex flex-row">
        <div class="w-1/6 bg-gray-200 rounded-l-xl h-full"></div>
        <input class="flex-auto dark:bg-gray-700 py-2 px-6 rounded-r-xl" type="text" placeholder="Course" v-model="article.course">
      </div>
    </div>
    <br>
  </div>
</template>

<script>
  import EditorJS from '@editorjs/editorjs';
  import CodeTool from '@editorjs/code';
  import List from '@editorjs/list';
  import Header from '@editorjs/header';
  import Alert from 'editorjs-alert';
  import InlineCode from '@editorjs/inline-code';

  export default {
    name: "editor",
    props: {
      action: String,
      article_id: String
    },
    data() {
      return {
        article: {},
        image: null,
        content: null,
        editor: null,
        errors: [],
        labels: ['synth', 'tool', 'module', 'effect', 'composition']
      }
    },
    created() {
      this.init();
    },
    methods: {
      init() {
        this.article = {name: '', url: '', github: '', youtube: '', interactive: false, personal: false, course: '', label: '', project_url: ''};

        if(this.article_id !== undefined && this.action === 'edit') {
          axios.get('/fetch/project/'+this.article_id).then(res => {
            this.article = res.data;
            if(this.editor === null) {
              this.renderEditor();
            }
          });
        } else if(this.editor === null) {
          this.renderEditor();
        }
      },
      renderEditor() {
        let data;
        if(this.article.content) {
          data = JSON.parse(this.article.content);
        } else {
          data = null;
        }

        console.log(this.article.content);
        this.editor = new EditorJS({
          holder: 'editor',
          data: data,
          tools: {
            header: {
              class: Header,
              config: {
                placeholder: 'Header goes here.',
                levels: [1, 2, 3, 4, 5, 6],
                defaultLevel: 3
              }
            },
            code: CodeTool,
            inlineCode: InlineCode,
            list: List,
            alert: Alert
          }})
      },
      handleDrop(e) {
        let droppedFiles = e.target.files || e.dataTransfer.files;
        if(!droppedFiles) return;

        let filetype = droppedFiles[0].type.split('/');

        if(filetype[0] === 'image') {
          this.image = droppedFiles[0];
        } else {
          this.errors.push('File type not supported');
        }
      },
      fileDialog() {
        $('#dropzone').click();
      },
      storeEdits() {
        this.editor.save().then((content) => {
          let fd = new FormData();
          fd.append('action', this.action);

          if(this.action === 'edit') {
            fd.append('id', this.article.id);
          }
          fd.append('name', this.article.name);
          fd.append('description', this.article.name);

          if(this.image !== null) {
            fd.append('image', this.image);
          }

          fd.append('project_url', this.article.project_url);
          fd.append('github', this.article.github);
          fd.append('youtube', this.article.youtube);

          fd.append('interactive', this.article.interactive ? 1 : 0);
          fd.append('personal', this.article.personal ? 1 : 0);
          fd.append('highlight', this.article.highlight ? 1 : 0);

          fd.append('course', this.article.course);
          fd.append('label', this.article.label);

          fd.append('content', JSON.stringify(content));


          axios.post('/make/project', fd, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }).then(res => {
            console.log(res.data);
            this.article = res.data;
          });

        });
      }
    },
    watch: {
      article_id() {
        this.init();
      },
      action() {
        this.init();
      }
    }
  }
</script>

<style>

</style>