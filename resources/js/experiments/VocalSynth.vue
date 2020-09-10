<template>
  <div id="vocalSynth">
    <button @click="init()" v-if="screen === 0">Start Audio</button>

    <div v-else>
      <div class="flex w-100 mb-5 border-2 border-teal-300">
        <div class="flex-auto w-1/3 p-4">
          <p class="font-light text-lg">Global</p>

          <input type="checkbox" id="mute" v-model="channel.mute"><label for="mute"> Mute</label>
          <br>
          <input type="checkbox" id="hold" v-model="hold"><label for="hold"> Hold</label>
          <br>

          <ul class="set">
            <li :class="[[1, 3, 6, 8, 10].includes(pianoKeys.indexOf(key)) ? 'black' : 'white']+' '+key" v-for="key in pianoKeys" @mousedown="play(key)" @mouseup="play()"></li>
          </ul>
        </div>

        <div class="flex-auto w-1/3 p-4">
          <p class="font-light text-lg">Filter</p>

          <small>Cutoff (pre)</small><br>
          <input type="range" min="100" max="10000" step="100" v-model="cutoff">
          <br>

          <small>Cutoff (post)</small><br>
          <input type="range" min="100" max="10000" step="100" v-model="cutoff_post">
          <br>

          <small>Gain</small><br>
          <input type="range" min="0" max="48" v-model="gain">
        </div>

        <div class="flex-auto w-1/3 p-4">
          <p class="font-light text-lg">Oscillators</p>

          <div class="bg-teal-100 border border-teal-200 p-2">
            <div class="flex">
              <p class="text-teal-400 font-bold flex-auto">LFO</p>

              <button @click="toggleLFO()" class="text-sm font-light px-2 py-1" :class="[lfo_enable ? ' text-white bg-teal-500' : ' text-gray-700 bg-white']">Enable</button>
            </div>

            <div class="flex">
              <div class="flex-auto">
                <small>Rate</small><br>
                <input type="number" min="0.001" max="500" v-model="lfo_param.rate">
              </div>
              <div class="flex-auto">
                <small>Depth</small><br>
                <input type="number" min="1" max="1000" v-model="lfo_param.depth">
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="p-2 border-2 border-teal-300">
        <p class="font-light text-lg">Vowels</p>
        <button v-for="(formants, vow) in vowels" class="p-3" :class="[vow === vowel ? ' text-teal-500' : ' text-teal-300']" @click="setVowel(vow)">{{vow}}</button>
      </div>
    </div>
  </div>
</template>

<script>
  import * as Tone from "tone";

  export default {
    name: "VocalSynth",
    data() {
      return {
        screen: 0,
        vowels: {
          a: [[800, 0, 80], [1150, -6, 90], [2900, -32, 120], [3900, -20, 130], [4950, -50, 140]],
          e: [[350, 0, 60], [2000, -20, 100], [2800, -15, 120], [3600, -40, 150], [4950, -56, 200]],
          o: [],
          u: [],
          i: []
        },
        pianoKeys: ['c', 'c#', 'd', 'd#', 'e', 'f', 'f#', 'g', 'g#', 'a', 'a#', 'b'],
        octave: 3,
        vowel: 'a',
        synth: null,
        channel: null,
        prefilter: null,
        postfilter: null,
        filters: [],
        env: null,
        gain: 6,
        cutoff: 2000,
        cutoff_post: 3000,
        frequency: 220,
        playing: false,
        hold: false,
        lfo: null,
        lfo_param: {rate: 1, depth: 1, center: 1},
        lfo_enable: false
      }
    },
    methods: {
      init() {
        const foo = async () => {
          await Tone.start();
          this.screen = 1;
          this.channel = new Tone.Channel(-1 * this.gain, 0).toMaster();
        };

        foo();
      },
      play(key = null) {
        if(key !== null) {
          let convkey = key + this.octave;
          this.frequency = new Tone.Midi(convkey).toFrequency();
        }

        if(this.playing && !this.hold) {
          const cleanup = async () => {
            await this.env.triggerRelease();
            this.prefilter = null;
            this.filters = [];
            this.synth = null;
          };

          cleanup();
        } else if(!this.playing) {
          // Create a filter that goes before the formant bank
          this.prefilter = new Tone.Filter(this.cutoff, 'lowpass');

          // Create a filter to go after the formant bank
          this.postfilter = new Tone.Filter(this.cutoff_post, 'lowpass').connect(this.channel);

          // Create an envelope for the synth
          this.env = new Tone.AmplitudeEnvelope({'attack': 0.1, 'decay': 0.2, 'sustain': 1.0, 'release': 0.8}).connect(this.prefilter);

          // Create the synth
          this.synth = new Tone.Oscillator(this.frequency, 'square').connect(this.env).start();

          // Set the vowel
          this.setVowel(this.vowel);

          // Trigger the envelope
          this.env.triggerAttack();
        }
        this.playing = !this.playing;
      },
      setVowel(vowel) {
        this.vowel = vowel;
        this.filters = [];

        for(let i = 0; i < this.vowels[vowel].length; i++) {
          let q = this.vowels[vowel][i][0] / this.vowels[vowel][i][2];
          let filter = new Tone.Filter({
              frequency: this.vowels[vowel][i][0],
              type: 'bandpass',
              gain: this.vowels[vowel][i][1],
              Q: q
          }).connect(this.postfilter);
          this.filters.push(filter);
          this.prefilter.connect(this.filters[i]);
        }
      },
      toggleLFO() {
        this.lfo_enable = !this.lfo_enable;
        if(this.lfo_enable) {
          this.lfo = new Tone.LFO({
            frequency: this.lfo_param.rate,
            min: this.frequency - (this.lfo_param.depth / 2),
            max: this.frequency + (this.lfo_param.depth / 2),
          }).connect(this.synth.frequency);
        } else {
          this.lfo = null;
          this.synth.frequency.value = this.frequency;
        }
      }
    },
    watch: {
      gain() {
        this.channel.volume.value = -1 * this.gain;
      },
      cutoff() {
        this.prefilter.frequency.value = this.cutoff;
      },
      cutoff_post() {
        this.postfilter.frequency.value = this.cutoff_post;
      },
      lfo_param() {
        this.lfo.frequency.value = this.lfo_param.rate;
        this.lfo.min = this.frequency - (this.lfo_param.depth / 2);
        this.lfo.max = this.frequency + (this.lfo_param.depth / 2);
      },
      frequency() {
        this.synth.frequency.value = this.frequency;
        this.lfo.min = this.frequency - (this.lfo_param.depth / 2);
        this.lfo.max = this.frequency + (this.lfo_param.depth / 2);
      }
    }
  }
</script>

<style scoped>
  ul {
    margin:0.75rem auto;
    position:relative;
    border-radius:1em;
    box-shadow:0 0 50px rgba(0,0,0,0.5) inset,0 1px rgba(212,152,125,0.2) inset,0 5px 15px rgba(0,0,0,0.5)
  }

  li {
    margin:0;
    padding:0;
    list-style:none;
    position:relative;
    float:left
  }

  ul .white {
    height:8em;
    width:3em;
    z-index:1;
    border-left:1px solid #bbb;
    border-bottom:1px solid #bbb;
    border-radius:0 0 5px 5px;
    box-shadow:-1px 0 0 rgba(255,255,255,0.8) inset,0 0 5px #ccc inset,0 0 3px rgba(0,0,0,0.2);
    background:linear-gradient(to bottom,#eee 0%,#fff 100%)
  }

  ul .white:active {
    border-top:1px solid #777;
    border-left:1px solid #999;
    border-bottom:1px solid #999;
    box-shadow:2px 0 3px rgba(0,0,0,0.1) inset,-5px 5px 20px rgba(0,0,0,0.2) inset,0 0 3px rgba(0,0,0,0.2);
    background:linear-gradient(to bottom,#fff 0%,#e9e9e9 100%)
  }

  .black {
    height:4em;
    width:1em;
    margin:0 0 0 -1.5em;
    z-index:2;
    border:1px solid #000;
    border-radius:0 0 3px 3px;
    box-shadow:-1px -1px 2px rgba(255,255,255,0.2) inset,0 -5px 2px 3px rgba(0,0,0,0.6) inset,0 2px 4px rgba(0,0,0,0.5);
    background:linear-gradient(45deg,#222 0%,#555 100%)
  }

  .black:active {
    box-shadow:-1px -1px 2px rgba(255,255,255,0.2) inset,0 -2px 2px 3px rgba(0,0,0,0.6) inset,0 1px 2px rgba(0,0,0,0.5);
    background:linear-gradient(to right,#444 0%,#222 100%)
  }

  .a,.g,.b,.d,.e,.f {
    margin:0 0 0 -1em
  }

  ul li:first-child {
    border-radius:5px 0 5px 5px
  }

  ul li:last-child {
    border-radius:0 5px 5px 5px;
    width: 2em;
  }
</style>