<template>
  <div class="bg-gray-100 border-2 border-teal-300 rounded-lg p-3">
    <div v-if="ready">
      <div class="p-4 mb-4 bg-blue-200 rounded-md border-r-2 border-blue-500">
        <h4 class="text-xl text-blue-600 font-bold">Input</h4>

        <button @click="toggleMic()" class="mr-2">
          <i class="material-icons text-gray-500" v-if="!recording">mic</i>
          <i class="material-icons text-red-500" v-else>mic_off</i>
        </button>

        <button @click="toggleOsc()">
          <i class="material-icons text-blue-500">graphic_eq</i>
        </button>

        <span class="font-bold text-red-500" v-if="recording">listening...</span>

        <div class="p-2 rounded-lg bg-blue-100 mt-3">
          <h4 class="text-lg text-blue-600 font-bold">Filter</h4>
          <label>
            <small><b>Center Frequency</b>: {{ params.input_filter.frequency }}Hz</small><br>
            <input type="range" @change="inputFilter.frequency.value = params.input_filter.frequency" v-model="params.input_filter.frequency" min="0" max="5000" step="1">
          </label><br>

          <label>
            <small><b>Rolloff</b>: {{ params.input_filter.rolloff }}dB/octave</small><br>
            <input type="range" @change="inputFilter.rolloff = params.input_filter.rolloff" v-model="params.input_filter.rolloff" min="-48" max="0" step="12">
          </label><br>
        </div>
      </div>

      <div class="flex">
        <div class="w-1/2 pr-2">
          <div class="p-4 bg-orange-200 rounded-md border-r-2 border-orange-500">
            <h4 class="text-xl text-orange-600 font-bold">Left</h4>

            <label>
              <small><b>Delay Time</b>: {{ params.delay_time.left * 1000 }}ms</small><br>
              <input type="range" @change="delayFX.set('delay_time', 'left', params.delay_time.left)" v-model="params.delay_time.left" min="0" max="1" step="0.001">
            </label><br>

            <label>
              <small><b>Feedback</b>: {{ Math.round(params.feedback.left * 100) }}%</small><br>
              <input type="range" @change="delayFX.set('feedback', 'left', params.feedback.left)" v-model="params.feedback.left" min="0" max="0.9" step="0.01">
            </label><br>

            <label>
              <small><b>Crossfeed</b>: {{ Math.round(params.crossfeed.left * 100) }}%</small><br>
              <input type="range" @change="delayFX.set('crossfeed', 'left', params.crossfeed.left)" v-model="params.crossfeed.left" min="0" max="0.9" step="0.01">
            </label><br>

          </div>
        </div>

        <div class="w-1/2 pl-2">
          <div class="p-4 bg-green-200 rounded-md border-r-2 border-green-500">
            <h4 class="text-xl text-green-600 font-bold">Right</h4>

            <label>
              <small><b>Delay Time</b>: {{ params.delay_time.right * 1000 }}ms</small><br>
              <input type="range" @change="delayFX.set('delay_time', 'right', params.delay_time.right)" v-model="params.delay_time.right" min="0" max="1" step="0.001">
            </label><br>

            <label>
              <small><b>Feedback</b>: {{ Math.round(params.feedback.right * 100) }}%</small><br>
              <input type="range" @change="delayFX.set('feedback', 'right', params.feedback.right)" v-model="params.feedback.right" min="0" max="0.9" step="0.01">
            </label><br>

            <label>
              <small><b>Crossfeed</b>: {{ Math.round(params.crossfeed.right * 100) }}%</small><br>
              <input type="range" @change="delayFX.set('crossfeed', 'right', params.crossfeed.right)" v-model="params.crossfeed.right" min="0" max="0.9" step="0.01">
            </label><br>

          </div>
        </div>
      </div>
    </div>

    <div v-else>
      <button @click="startCtx()">start</button>
    </div>
  </div>
</template>

<script>
  import {ComplexDelay} from '../../../public/project/ko2a-2/complexDelay';
  import * as Tone from "tone";

  export default {
    name: "KO2aDelay",
    data() {
      return {
        ready: false,
        mic: null,
        inputFilter: null,
        recording: false,
        delayFX: null,
        gainNode: null,
        osc: null,
        player: null,
        params: {
          feedback: {
            left: 0,
            right: 0
          },
          crossfeed: {
            left: 0,
            right: 0
          },
          delay_time: {
            left: 0.01,
            right: 0.05
          },
          input_filter: {
            frequency: 1000,
            rolloff: -24
          }
        }
      }
    },
    mounted() {

    },
    methods: {
      async startCtx() {
        await Tone.start();

        let masterNode = new Tone.Gain(0.5).toMaster();
        this.gainNode = new Tone.Gain(0.5).connect(masterNode);
        this.delayFX = new ComplexDelay(masterNode);
        this.osc = new Tone.MonoSynth().fan(this.gainNode, this.delayFX.src);

        this.mic = new Tone.UserMedia().fan(this.gainNode, this.delayFX.src);
        this.inputFilter = new Tone.Filter(1000, 'bandpass', -24).connect(this.delayFX.src);

        this.player = new Tone.Player('/data/samples/kick.wav').fan(this.gainNode, this.delayFX.src);

        // Give it the go
        this.ready = true;
      },
      toggleOsc() {
        //this.osc.triggerAttackRelease('C4', '8n');
        this.player.start(Tone.Time.now);
      },
      toggleMic() {
        if(this.recording) {
          this.mic.close();
          this.recording = false;
        } else {
          this.mic.open().then(() => {
            this.recording = true;
          }).catch(() => {
            this.recording = false;
          });
        }
      }
    }
  }
</script>

<style scoped>

</style>