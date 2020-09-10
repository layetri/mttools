<template>
  <div id="instrumentTrainer">
    <div class="w-1/2 mx-auto" v-if="step === 0">
      <h1 class="text-3xl font-thin">Instrument Trainer</h1>
      <p class="font-light">This tool helps training the recognition of instrument sound/timbre. Please report any bugs to mt@layetri.nl.<br>
        Samples are taken from <a href="https://philharmonia.co.uk/resources/sound-samples/" class="text-teal-500">the Philharmonia</a>.</p>
      <br>
      <small class="cursor-pointer">
        <span class="mr-4" @click="lang = 'en'" :class="[lang === 'en' ? 'text-teal-600' : '']">English</span>
        <span @click="lang = 'nl'" :class="[lang === 'nl' ? 'text-teal-600' : '']">Nederlands</span>
      </small>
      <br>
      <p class="font-bold text-teal-400 cursor-pointer mt-4" @click="start()">Start</p>
    </div>


    <div class="w-1/2 mx-auto font-light" v-if="step === 1">
      <h5 class="text-2xl font-thin mb-10">Instrument Trainer</h5>

      <div class="w-100 rounded border-2 p-1" :class="'bg-'+aboutLast[1]+'-200 border-'+aboutLast[1]+'-300'" v-if="aboutLast !== null">
        <p :class="'text-'+aboutLast[1]+'-500'" v-html="aboutLast[0]"></p>
      </div>

      <div class="w-100">
        <p class="font-bold text-teal-400 cursor-pointer" @click="togglePlayState()">
          <span v-if="playing">pause</span>
          <span v-else>play</span>
        </p>
        <div class="w-100" style="text-align: right; margin-top: -20px;">
          {{score}} / {{total}}
        </div>
      </div>

      <div class="p-3" v-for="(inst, cat) in instruments">
        <p class="text-xs font-bold uppercase tracking-wide text-gray-500" v-html="parseText(cat)"></p>
        <div>
          <p class="text-sm cursor-pointer capitalize" v-html="parseText(instrument)" v-for="instrument in inst" @click="checkAnswer(instrument)"></p>
        </div>
      </div>

      <div class="w-100">
        <p class="text-teal-400 cursor-pointer font-bold" @click="next()" v-if="shownext">next</p>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "InstrumentTrainer",
    data() {
      return {
        instruments: [],
        translations: [],
        selinstr: null,
        selsample: null,
        score: 0,
        total: 1,
        step: 0,
        mode: 'solo',
        ctx: new Audio(),
        base: '/data/instrumentTrainer/samples/',
        playing: false,
        aboutLast: null,
        shownext: false,
        lang: 'en'
      }
    },
    created() {
      axios.get('/data/instrumentTrainer/data.json')
        .then(res => {
          this.instruments = res.data.instruments;
          this.translations = res.data.translations;
        });

      this.ctx.onended = e => {
        this.ctx.currentTime = 0;
        this.togglePlayState();
      }
    },
    methods: {
      parseText(text) {
        return this.translations[this.lang][text];
      },
      start() {
        this.step = 1;
        this.load();
      },
      togglePlayState() {
        if(this.playing) {
          this.ctx.pause();
        } else {
          this.ctx.play();
        }
        this.playing = !this.playing;
      },
      load() {
        let list = [];
        for(let [key, value] of Object.entries(this.instruments)) {
          for(let i = 0; i < value.length; i++) {
            list.push(value[i]);
          }
        }

        let ind = this.randomIndex(list.length);
        this.selinstr = list[ind];

        this.selsample = this.randomIndex(10)+'.mp3';
        this.ctx.src = this.base+this.mode+'/'+this.selinstr+'/'+this.selinstr+'_'+this.selsample;

        this.ctx.play();
        this.playing = true;
      },
      checkAnswer(answer) {
        let correct = answer === this.selinstr;
        if(correct) {
          this.score++;
          this.aboutLast = ['Good job!', 'green'];
        } else {
          this.aboutLast = ['Too bad. The correct answer was: <b>'+this.parseText(this.selinstr)+'<\/b>.', 'red'];
        }
        this.shownext = true;
      },
      next() {
        this.total++;
        this.load();
        this.aboutLast = null;
        this.shownext = false;
      },
      randomIndex(max) {
        return Math.floor(Math.random() * Math.floor(max));
      }
    }
  }
</script>

<style scoped>

</style>