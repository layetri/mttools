<template>
  <div>
    <div class="mb-4 p-2" @click="openLink(item.slug)" v-for="item in posts">
      <div class="bg-white rounded-lg shadow p-4">
        <h1 class="text-2xl">{{ item.title }}</h1>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "BlogList",
    created() {
      axios.get('/fetch/blog/posts').then(res => {
        this.posts = res.data;
      });
    },
    data() {
      return {
        posts: []
      }
    },
    methods: {
      openLink(slug) {
        window.location.href = '/blog/post/'+slug;
      }
    }
  }
</script>

<style scoped>

</style>