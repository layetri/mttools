<template>
  <div class="border-2 border-teal-300 p-4 bg-gray-100">
    <button @click="startCtx()">start</button>
    <button @click="recordToggle()">
      <i class="material-icons text-red-500" v-if="!recording">fiber_manual_record</i>
      <i class="material-icons text-red-500" v-else>stop</i>
    </button>

    <button @click="playToggle()">
      <i class="material-icons text-gray-600" v-if="!playing">play_arrow</i>
      <i class="material-icons text-gray-600" v-else>stop</i>
    </button>
  </div>
</template>

<script>
  import {GrainDelay} from '../../../public/project/ko2a/grainDelay';
  import * as Tone from "tone";

  export default {
    name: "KO2aGranular",
    data() {
      return {
        graindelay: null,
        gain: null,
        recording: false,
        playing: false,
      }
    },
    methods: {
      startCtx() {
        Tone.start();

        let gain = new Tone.Gain(0.1).toMaster();

        this.graindelay = new GrainDelay(gain);
      },
      recordToggle() {
        if(this.recording) {
          this.graindelay.recorder.stop();
        } else {
          this.graindelay.recordToBuffer();
        }
        this.recording = !this.recording;
      },
      playToggle() {
        if(this.playing) {
          Tone.Transport.stop();
          this.graindelay.stopBuffer();
        } else {
          Tone.Transport.start();
          this.graindelay.playBuffer();
        }
        this.playing = !this.playing;
      }
    }
  }
</script>

<style scoped>

</style>