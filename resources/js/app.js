require('./bootstrap');

import Vue from 'vue';
import Vue_mq from 'vue-mq';

window.Vue = require('vue');

Vue.prototype.$ = require('jquery');
Vue.use(Vue_mq, {
  breakpoints: { // default breakpoints - customize this
    sm: 450,
    md: 1250,
    lg: Infinity,
  },
  defaultBreakpoint: 'sm' // customize this for SSR
});

Vue.component('navbar', require('./parts/Nav.vue').default);
Vue.component('interval-trainer', require('./tools/IntervalTrainer.vue').default);
Vue.component('instrument-trainer', require('./tools/InstrumentTrainer.vue').default);

// MidiMeet on MT is now O B S O Y E E T
// Vue.component('midi-meet', require('./tools/MidiMeet.vue').default);
// Vue.component('midi-meet-editor', require('./midimeet/Editor.vue').default);
Vue.component('featured-projects', require('./content/FeaturedWorks').default);
Vue.component('login-form', require('./parts/login').default);

// Donut components
Vue.component('donut-main', require('./projects/donut/Main').default);

// Blog components
Vue.component('blog-list', require('./blog/BlogList').default);
Vue.component('post', require('./blog/Post').default);
Vue.component('blog-sidebar', require('./blog/BlogSidebar').default);

// Admin components
Vue.component('admin-container', require('./admin/container').default);
Vue.component('admin-portfolio', require('./admin/portfolio').default);
Vue.component('admin-portfolio-viewer', require('./admin/PortfolioViewer').default);
Vue.component('admin-editor', require('./admin/editor').default);
Vue.component('admin-blog', require('./admin/blog').default);
Vue.component('admin-blog-editor', require('./admin/BlogEditor').default);

Vue.component('project-type', require('./content/ProjectTypeBadge').default);

Vue.component('guides-list', require('./content/GuidesList.vue').default);
Vue.component('tools-list', require('./content/ToolsList.vue').default);
Vue.component('experiments-list', require('./content/ExperimentsList.vue').default);
Vue.component('projects-list', require('./content/ProjectList.vue').default);
Vue.component('project-view', require('./content/ProjectPage.vue').default);
Vue.component('docs-function', require('./content/DocsFunction.vue').default);

Vue.component('scheme-lilypond-docs', require('./guides/SchemeLilypondDocs.vue').default);

Vue.component('exp-vocal-synth', require('./experiments/VocalSynth.vue').default);
Vue.component('exp-editor', require('./experiments/Editor.vue').default);

Vue.component('ko2a-looper', require('./projects/KO2aLooper.vue').default);
Vue.component('ko2a-delay', require('./projects/KO2aDelay.vue').default);
Vue.component('ko2a-granular', require('./projects/KO2aGranular.vue').default);

const app = new Vue({
  el: '#app'
});