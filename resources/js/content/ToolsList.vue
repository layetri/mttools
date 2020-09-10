<template>
  <div>
    <table class="table-auto">
      <thead>
        <tr>
          <th class="px-4 py-2">Title</th>
          <th class="px-4 py-2">Type</th>
          <th class="px-4 py-2">Course</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="tool in tools">
          <td class="border px-4 py-2">
            <a :href="'/tools/'+tool.url" v-html="tool.name"></a>
          </td>
          <td class="border px-4 py-2 text-center">
            <span class="border rounded text-xs uppercase px-4 py-1" :class="'bg-'+tool.type[1]+'-100 text-'+tool.type[1]+'-400 border-'+tool.type[1]+'-300'" v-html="tool.type[0]"></span>
          </td>
          <td class="border px-4 py-2 text-center">
            <span class="border rounded text-xs uppercase px-4 py-1" :class="'bg-'+tool.course[1]+'-100 text-'+tool.course[1]+'-400 border-'+tool.course[1]+'-300'" v-html="tool.course[0]"></span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    name: "ToolsList",
    data() {
      return {
        tools: [
            {url: 'instrument-trainer', name: 'Instrument Trainer', type: ['online', 'green'], course: ['muzbas', 'red']},
            {url: 'midi-meet', name: 'MidiMeet', type: ['online', 'green'], course: ['general', 'gray']},
            //{url: '', name: '', type: ['', ''], course: ['', '']},
        ]
      }
    }
  }
</script>

<style scoped>

</style>