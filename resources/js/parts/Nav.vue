<template>
  <div class="navbar fixed w-full bg-white dark:bg-black p-5 shadow-md top-0 select-none" :class="toggle ? 'h-full' : ''" style="z-index: 100;">
    <div class="container flex align-middle mx-auto">
      <div class="flex-none">
        <a href="/">
          <h4 class="text-gray-700 dark:text-gray-200 text-xl font-normal">
            layetri<span class="text-teal-400">, music technologist</span>
          </h4>
        </a>
      </div>

      <div class="flex-auto"></div>

      <div class="flex align-middle" v-if="!['md', 'lg'].includes($mq)">
        <div class="m-auto">
          <button @click="toggle = !toggle" class="font-bold uppercase text-sm focus:outline-none" :class="toggle ? 'text-teal-500' : 'text-gray-500'">Menu</button>
        </div>
      </div>

      <div class="flex md:w-auto w-full items-stretch align-middle" v-else>
        <div class="m-auto mr-4" v-for="link in links" :key="links.indexOf(link)">
          <a :href="'/'+link.slug" class="text-gray-500 hover:text-teal-500 uppercase tracking-wider text-xs">{{ link.text }}</a>
        </div>

        <div class="flex flex-row items-center cursor-pointer mr-4" @click="toggleDarkMode()">
          <div :class="!darkmode ? 'bg-teal-500 shadow-md p-3 rounded-md' : 'bg-gray-200 p-2 rounded-l-md'"></div>
          <div :class="darkmode ? 'bg-teal-500 shadow-md p-3 rounded-md' : 'bg-gray-800 p-2 rounded-r-md'"></div>
        </div>

        <div class="m-auto" v-if="isAdmin">
          <a href="/admin" class="text-white font-bold uppercase bg-teal-500 hover:bg-teal-700 px-4 py-1 rounded shadow text-xs">Admin</a>
        </div>
      </div>
    </div>

    <div class="w-full mt-4 p-4" v-if="toggle">
      <div class="m-auto p-4" v-for="link in links" :key="links.indexOf(link)">
        <a :href="'/'+link.slug" class="text-gray-500 hover:text-teal-500 uppercase tracking-wider">{{ link.text }}</a>
      </div>

      <div class="m-auto p-4" v-if="isAdmin">
        <a href="/admin" class="text-white font-bold uppercase bg-teal-500 hover:bg-teal-700 px-6 py-3 rounded shadow">Admin</a>
      </div>


    </div>
  </div>
</template>

<script>
import Cookies from "js-cookie";

export default {
  name: "Nav",
  props: {
    admin: String
  },
  created() {
    if(this.darkmode) {
      document.getElementsByTagName("html")[0].setAttribute("class", "dark");
    } else {
      document.getElementsByTagName("html")[0].removeAttribute("class");
    }
  },
  data() {
    return {
      toggle: false,
      links: [
        {slug: '', text: 'home'},
        {slug: 'projects', text: 'portfolio'},
        {slug: 'blog', text: 'blog'},
        {slug: 'student', text: 'mt resources'},
      ],
      darkmode: Cookies.get("darkmode") === "true"
    }
  },
  computed: {
    isAdmin() {
      return Number(this.admin);
    }
  },
  methods: {
    toggleDarkMode() {
      this.darkmode = !this.darkmode;
      Cookies.set("darkmode", this.darkmode);

      let html = document.getElementsByTagName("html");
      if(this.darkmode) {
        html[0].setAttribute("class", "dark");
      } else {
        html[0].removeAttribute("class");
      }
    }
  },
}
</script>

<style scoped>

</style>