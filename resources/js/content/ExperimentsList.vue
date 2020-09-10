<template>
  <div>
    <table class="table-auto">
      <thead>
        <tr>
          <th class="px-4 py-2">Title</th>
          <th class="px-4 py-2">Type</th>
          <th class="px-4 py-2">Technology</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="exp in exps">
          <td class="border px-4 py-2">
            <a :href="'/experiments/'+exp.url" v-html="exp.name"></a>
          </td>
          <td class="border px-4 py-2 text-center">
            <span class="border rounded text-xs uppercase px-4 py-1" :class="'bg-'+exp.type[1]+'-100 text-'+exp.type[1]+'-400 border-'+exp.type[1]+'-300'" v-html="exp.type[0]"></span>
          </td>
          <td class="border px-4 py-2 text-center">
            <span class="border rounded text-xs uppercase px-4 py-1" :class="'bg-'+exp.lang[1]+'-100 text-'+exp.lang[1]+'-400 border-'+exp.lang[1]+'-300'" v-html="exp.lang[0]"></span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    name: "ExperimentsList",
    data() {
      return {
        exps: [
            {url: 'vocal-synth', name: 'Formant Vocal Synth', type: ['synth', 'blue'], lang: ['ToneJS', 'pink']},
            //{url: '', name: '', type: ['', ''], lang: ['', '']},
        ]
      }
    }
  }
</script>

<style scoped>

</style>