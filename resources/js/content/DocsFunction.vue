<template>
  <div>
    <h3 class="mb-2" :id="func.name"><code v-html="func.name"></code></h3>

    <b>Description</b>
    <p class="mb-2" v-html="func.desc"></p>

    <b>Arguments</b>
    <ul class="mb-2">
      <li v-for="arg in func.arguments"><code v-html="arg[0]"></code> {{ arg[1] }}</li>
    </ul>

    <b>Syntax</b>
    <pre class="py-2 mb-8"><code>{{func.syntax}}</code></pre>
  </div>
</template>

<script>
  export default {
    name: "DocsFunction",
    props: {
      // Array of functions styled like:
      // {name: '', desc: '', arguments: [['', ''], ['', '']], syntax: ''}
      func: Object
    }
  }
</script>

<style scoped>

</style>