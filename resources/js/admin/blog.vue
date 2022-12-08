<template>
  <div class="w-full h-full flex flex-row">
    <div class="w-1/5 border-r flex-shrink-0">
      <div class="px-4 m-4 py-2 rounded-lg bg-teal-500 text-white font-bold tracking-wider uppercase cursor-pointer shadow text-sm text-center" @click="[create = true, edit = false]">
        create
      </div>

      <div class="px-4 py-2 m-2 border rounded-lg shadow cursor-pointer flex flex-row" @click="[selected = item, create = false]" :class="[selected === item ? 'bg-gray-200 border-teal-500' : 'bg-white']" v-for="item in posts">
        <span class="flex-auto">{{item.title}}</span>
        <span v-if="!item.public" class="fas fa-eye-slash text-red-200"></span>
      </div>
    </div>
    <div class="flex-auto p-4" v-if="posts.length > 0 || create">
      <admin-blog-editor :post_id="selected.id" :action="edit ? 'edit' : 'create'" v-if="edit || create" @close-editor="[edit = false, create = false]"></admin-blog-editor>

<!--      <admin-blog-viewer :article="posts[selected]" v-else @open-editor="edit = true"></admin-blog-viewer>-->
    </div>
  </div>
</template>

<script>
export default {
  name: "Blog",
  props: {
    user: Object
  },
  data() {
    return {
      posts: [],
      selected: 0,
      edit: false,
      create: false
    }
  },
  created() {
    axios.get('/fetch/blog/posts').then(res => {
      this.posts = res.data;
    });
  }
}
</script>

<style scoped>

</style>