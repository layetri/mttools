<template>
  <div>
    <div class="w-full flex flex-row p-4">
      <div class="text-uppercase text-gray-400 text-sm tracking-widest uppercase">
        Blog Post editor
      </div>
      <div class="flex-auto"></div>
      <div>
        <button class="mr-4 text-gray-500 font-bold uppercase bg-white hover:bg-gray-50 px-4 py-1 rounded shadow text-xs" @click="$emit('close-editor')">cancel</button>
        <button class="text-white font-bold uppercase bg-teal-500 hover:bg-teal-700 px-4 py-1 rounded shadow text-xs" @click="storeEdits">save</button>
      </div>
    </div>

    <div>
      <input class="text-2xl mb-4 w-full py-2 px-6 rounded-xl" type="text" placeholder="Title" v-model="post.title">
    </div>

    <div class="w-full bg-white my-4 p-6 rounded-xl text-center text-gray-400 dropzone cursor-pointer" @drop.prevent="handleDrop" @dragover.prevent @click="fileDialog">
      <input type="file" id="dropzone" @change="handleDrop" hidden>
      Drop image here
    </div>

    <div class="mb-4 layoutEngine">
      <div class="w-full bg-white rounded-xl p-4" id="editor"></div>
    </div>

    <div class="grid grid-cols-2 mb-10">
      <div class="p-4 pl-0 w-full rounded-xl flex flex-row">
        <div class="w-1/6 bg-gray-200 rounded-l-xl h-full"></div>
        <input class="flex-auto py-2 px-6 rounded-r-xl" type="text" placeholder="Category" v-model="post.category">
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
    post_id: String
  },
  data() {
    return {
      post: {},
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
      this.post = {title: '', body: '', publish: false, category: ''};

      if(this.post_id !== undefined && this.action === 'edit') {
        axios.get('/fetch/blog/post/'+this.post_id).then(res => {
          this.post = res.data;
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
      if(this.post.content) {
        data = JSON.parse(this.post.content);
      } else {
        data = null;
      }

      console.log(this.post.content);
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
          fd.append('id', this.post.id);
        }
        fd.append('title', this.post.title);

        if(this.image !== null) {
          fd.append('image', this.image);
        }

        fd.append('category', this.post.category);
        fd.append('body', JSON.stringify(content));


        axios.post('/make/blog/post', fd, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(res => {
          console.log(res.data);
          this.post = res.data;
        });

      });
    }
  },
  watch: {
    post_id() {
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