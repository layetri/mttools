<template>
  <div class="flex flex-row h-full">
    <div class="w-1/6 p-4 pr-0 border-r dark:border-gray-600 flex-shrink-0">
      <div class="mb-5">
        <h5 class="text-lg font-light dark:text-gray-400">Welcome back, <br><span class="font-bold text-xl">{{ user.name }}</span></h5>
      </div>

      <div v-for="v in views" class="w-full px-4 py-2 rounded-l-lg mb-4 cursor-pointer" :class="[view === v ? 'bg-teal-500 text-gray-100' : 'text-gray-600']" @click="view = v">
        <span class="uppercase tracking-widest text-xs">{{ v }}</span>
      </div>
    </div>


    <div class="flex-auto">
      <admin-portfolio v-if="view === 'portfolio'"></admin-portfolio>
      <admin-blog v-if="view === 'blog'"></admin-blog>
    </div>
  </div>
</template>

<script>
  export default {
    name: "container",
    props: {
      user: Object
    },
    data() {
      return {
        view: 'portfolio',
        views: ['portfolio', 'guides', 'blog']
      }
    },

  }
</script>

<style scoped>

</style>