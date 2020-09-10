<template>
  <div>
    <table class="table-auto">
      <thead>
        <tr>
          <th class="px-4 py-2">Title</th>
          <th class="px-4 py-2">Type</th>
          <th class="px-4 py-2">Language</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="guide in guides">
          <td class="border px-4 py-2">
            <a :href="'/guides/'+guide.url" v-html="guide.name"></a>
          </td>
          <td class="border px-4 py-2 text-center">
            <span class="border rounded text-xs uppercase px-4 py-1" :class="'bg-'+guide.type[1]+'-100 text-'+guide.type[1]+'-400 border-'+guide.type[1]+'-300'" v-html="guide.type[0]"></span>
          </td>
          <td class="border px-4 py-2 text-center">
            <span class="border rounded text-xs uppercase px-4 py-1" :class="'bg-'+guide.lang[1]+'-100 text-'+guide.lang[1]+'-400 border-'+guide.lang[1]+'-300'" v-html="guide.lang[0]"></span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    name: "GuidesList",
    data() {
      return {
        guides: [
            {url: 'using-idea', name: 'Using IDEA', type: ['tools', 'green'], lang: ['scheme', 'red']},
            {url: 'scheme-lilypond-docs', name: 'Scheme to LilyPond Documentation', type: ['docs', 'blue'], lang: ['scheme', 'red']},
            {url: 'using-webstorm', name: 'Using WebStorm', type: ['tools', 'green'], lang: ['javascript', 'orange']},
            {url: 'using-git', name: 'Using Git', type: ['tools', 'green'], lang: ['git', 'gray']},
            //{url: '', name: '', type: ['', ''], lang: ['', '']},
        ]
      }
    }
  }
</script>

<style scoped>

</style>