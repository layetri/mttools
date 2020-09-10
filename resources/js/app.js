require('./bootstrap');

import Vue from 'vue';

window.Vue = require('vue');

Vue.prototype.$ = require('jquery');

Vue.component('interval-trainer', require('./tools/IntervalTrainer.vue').default);
Vue.component('instrument-trainer', require('./tools/InstrumentTrainer.vue').default);

// MidiMeet on MT is now O B S O Y E E T
// Vue.component('midi-meet', require('./tools/MidiMeet.vue').default);
// Vue.component('midi-meet-editor', require('./midimeet/Editor.vue').default);

Vue.component('guides-list', require('./content/GuidesList.vue').default);
Vue.component('tools-list', require('./content/ToolsList.vue').default);
Vue.component('experiments-list', require('./content/ExperimentsList.vue').default);
Vue.component('projects-list', require('./content/ProjectList.vue').default);
Vue.component('docs-function', require('./content/DocsFunction.vue').default);

Vue.component('scheme-lilypond-docs', require('./guides/SchemeLilypondDocs.vue').default);

Vue.component('exp-vocal-synth', require('./experiments/VocalSynth.vue').default);
Vue.component('exp-editor', require('./experiments/Editor.vue').default);

Vue.component('ko2a-looper', require('./projects/KO2aLooper.vue').default);

const app = new Vue({
  el: '#app'
});