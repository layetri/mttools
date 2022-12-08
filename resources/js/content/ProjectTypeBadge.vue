<template>
  <small class="uppercase px-4 py-1 rounded font-bold border text-xs w-max bg-opacity-80"
         :class="'text-'+colors[type]+'-500 border-'+colors[type]+'-500 bg-'+colors[type]+'-100'">
    {{type}}
  </small>
</template>

<script>
  export default {
    name: "ProjectTypeBadge",
    props: {
      type: String
    },
    data() {
      return {
        colors: {
          instrument: 'red',
          effect: 'blue',
          tool: 'green',
          module: 'orange'
        }
      }
    }
  }
</script>

<style scoped>

</style>