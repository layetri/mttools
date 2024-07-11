<template>
  <div class="p-4 rounded border-r-2 border-teal-300 bg-white mt-4">
    <div class="w-full text-center" v-if="!ready">
      <h5 class="font-bold text-teal-500 cursor-pointer" @click="startCtx()">Start the audio context</h5>
    </div>

    <div v-else>
      <div class="looper-transports flex items-center bg-teal-200 rounded mb-3 mx-2 p-2">
        <div class="mr-4">
          <button class="btn-none text-red-400" @click="startRecord()" v-if="!recording">
            <i class="material-icons">fiber_manual_record</i>
          </button>
          <button class="btn-none text-red-400" @click="stopRecord()" v-else>
            <i class="material-icons">stop</i>
          </button>
        </div>

        <div>
          <button class="btn-none" @click="startPlayback()" v-if="timekeeper === null">
            <i class="material-icons">play_arrow</i>
          </button>
          <button class="btn-none" @click="stopPlayback()" v-else>
            <i class="material-icons">stop</i>
          </button>
        </div>

        <span class="ml-3 text-teal-500 font-bold mr-4">{{ beatCount + 1 }}</span>
        <span class="font-bold text-teal-500 mr-2">{{bpm}}</span>
        <button @click="tap()" class="uppercase text-xs font-bold text-teal-700">Tap</button>

        <div class="flex-grow"></div>

        <div>
          <span class="ml-3 text-red-500 font-bold" v-if="recording">RECORDING</span>
        </div>
      </div>

      <div class="looper-effects">
        <h2 class="text-xl font-bold text-teal-500 mx-2 mb-3">Effects</h2>

        <div class="flex">
          <div class="w-1/4 px-2">
            <div class="p-5 bg-orange-100 border-r-2 rounded border-orange-300">
              <h3 class="text-orange-500 font-bold">FreeVerb</h3>
              <label>
                Amount: <br>
                <small>{{ reverb_amount }}</small><br>
                <input type="range" v-model="reverb_amount" min="0" max="1" step="0.01" @change="updateReverbAmount()">
              </label>
            </div>
          </div>

          <div class="w-1/4 px-2">
            <div class="p-5 bg-green-100 border-r-2 rounded border-green-300">
              <h3 class="text-green-500 font-bold">LowPass</h3>

              <label>
                Cutoff: <br>
                <small>{{ lp_cutoff }} Hz</small><br>
                <input type="range" v-model="lp_cutoff" min="20" max="10000" step="10">
              </label><br>

              <label>
                Resonance: <br>
                <small>{{ lp_res }}</small><br>
                <input type="range" v-model="lp_res" min="0.1" max="100" step="1">
              </label>
            </div>
          </div>
        </div>
      </div>



      <div class="looper-samples-list mt-2">
        <h2 class="text-xl font-bold text-blue-500 mx-2 mb-3">Samples</h2>

        <div class="flex">
          <div v-if="samples.length === 0" class="w-1/4 px-2">
            <div class="bg-blue-100 rounded text-blue-700 p-2 cursor-pointer mb-2 border-r-2 border-blue-700">
              <span class="text-blue-500 flex items-center">
                <span>Hit</span>
                <i class="material-icons text-red-400 text-md mx-1">fiber_manual_record</i>
                <span>to record a sample!</span>
              </span>
            </div>
          </div>

          <div v-for="(sample, index) in samples" class="w-1/4 px-2">
            <div class="bg-blue-100 rounded text-blue-700 p-2  mb-2 border-r-2 border-blue-700">
              <button @click="playSample(index)" class="text-left cursor-pointer">
                <span class="font-bold">sample_{{index}}</span><br>
                <small>Click to preview</small>
              </button>
              <br><br>

              <div class="mb-4">
                <label>
                  <small>Number of buffers:</small><br>
                  <input type="number" v-model="sample.amount">
                </label><br>

                <label>
                  <small>Speed range:</small><br>
                  <input type="number" v-model="sample.speed_range">
                </label><br>

                <label class="mt-3">
                  <small>Time range:</small>
                  <section class="range-slider">
                    <input v-model="sample.startTime" min="0" :max="sample.duration" step="0.01" type="range">
                    <input v-model="sample.endTime" min="0" :max="sample.duration" step="0.01" type="range">
                  </section>
                </label>
                <br>

                <label class="mt-3">
                  <input type="checkbox" v-model="sample.fill"> Stretch to fill
                </label>
              </div>

              <button class="rounded px-4 py-1" :class="[selected === index ? 'bg-blue-600 text-white' : 'bg-blue-200 text-blue-500']" @click="selected = index">
                <i class="material-icons" v-if="selected !== index">add</i>
                <i class="material-icons" v-else>done</i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="px-2 mt-4">
        <small class="text-gray-400">Copyright &copy; 2020 Layetri @ HKU University of the Arts Utrecht.</small>
      </div>
    </div>
  </div>
</template>

<script>
  import * as Tone from "tone";

  export default {
    name: "KO2aLooper",
    data() {
      return {
        bpm: 120,
        timekeeper: null,
        taps: {
          abs: [],
          total: 0,
          amt: 0
        },
        bpmResetSwitch: null,

        buffers: [],
        samples: [],
        selected: null,
        recorder: null,
        recording: false,
        recLength: 0,
        recTimer: null,
        perm: false,
        ready: false,
        playback: null,
        beatCount: 0,

        // Effects
        reverb: null,
        reverb_amount: 0.5,
        lp_comb: null,
        lp: null,
        lp_cutoff: 10000,
        lp_res: 0.1,
        limit: null
      }
    },
    mounted() {
      this.playback = new Audio();

      if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia ({audio: true})
          .then(stream => {
            this.perm = true;
            this.recorder = new MediaRecorder(stream);

            this.recorder.ondataavailable = e => {
              this.samples.push({
                id: this.samples.length,
                sample: e.data,
                looping: false,
                fill: false,
                startTime: 0,
                endTime: this.recLength / 1000,
                duration: this.recLength / 1000,
                amount: Math.round(Math.random() * 15),
                reverse: 'shuffle',
                speed_range: Math.round(Math.random() * 20),
                min_speed: 0.2
              });
            }
          }).catch(error => {
            console.log('The following getUserMedia error occurred: ' + error);
          });
      } else {
        console.log('getUserMedia not supported on your browser!');
      }
    },
    methods: {
      async startCtx() {
        await Tone.start();

        // Initialize processing chain
        this.limit = new Tone.Limiter(-24).toMaster();
        const lp = new Tone.Filter(12000, 'lowpass', -24).connect(this.limit);
        this.reverb = new Tone.Freeverb().connect(lp);
        this.lp = new Tone.Filter(this.lp_cutoff, 'lowpass').connect(this.reverb);
        this.lp_comb = new Tone.LowpassCombFilter().connect(this.lp);

        // Give it the go
        this.ready = true;
      },
      startRecord() {
        // Record into sample list
        if(this.perm) {
          this.recording = true;
          this.recLength = 0;
          this.recorder.start();

          this.recTimer = setInterval(() => {
            this.recLength += 5;
          }, 5);
        }
      },
      stopRecord() {
        // Stop recording into sample list
        // Storing the recording is handled in the permission callback
        if(this.recording) {
          this.recording = false;
          clearInterval(this.recTimer);

          this.recorder.stop();
        }
      },
      startPlayback() {
        // Start global playback
        if(this.samples.length > 0) {
          let sample = this.samples[this.selected];
          this.spawnBuffers(this.selected, sample.amount);
        }

        setTimeout(() => {
          this.triggerScheduled();

          this.timekeeper = setInterval(() => {
            this.instructBuffers();
          }, 60000 / this.bpm);
        }, 20);
      },
      stopPlayback() {
        // Stop global playback
        clearInterval(this.timekeeper);

        this.timekeeper = null;
        this.beatCount = 0;
        for(let i = 0; i < this.buffers.length; i++) {
          this.buffers[i].stop(Tone.Time.now);
        }
      },
      instructBuffers() {
        if(this.beatCount === 3) {
          this.beatCount = 0;
          this.loopCount++;

          this.triggerScheduled();
        } else {
          this.beatCount++;
        }

        if(this.beatCount === 0) {

        }
      },
      triggerScheduled() {
        // If first beat, trigger sample start of appointed sample.
        let sample = this.samples[this.selected];
        for (let i = 0; i < this.buffers.length; i++) {
          // Fill in parameters
          if(sample.reverse === 'shuffle') {
            this.buffers[i].reverse = (Math.random() > 0.5);
          } else {
            this.buffers[i].reverse = sample.reverse;
          }

          if(sample.fill) {
            let full_time = 60 / this.bpm;
            let fact = full_time / (sample.endTime - sample.startTime);
            this.buffers[i].playbackRate = fact * Math.round(Math.random() * 5);
          } else {
            this.buffers[i].playbackRate = (Math.random() * sample.speed_range) + sample.min_speed;
          }

          this.buffers[i].start(Tone.Time.now, sample.startTime, (sample.endTime - sample.startTime));
        }
      },
      spawnBuffers(sample_id, amount) {
        // Handler for spawning new buffers, called when old buffer ends
        let sample = this.samples[sample_id];
        // Reset the buffer storage before spawning new buffers there.
        this.buffers = [];

        for(let i = 0; i < amount; i++) {
          let sample_location = URL.createObjectURL(sample.sample);
          let buff = new Tone.Player(sample_location).connect(this.lp_comb);

          // Fill in parameters
          if(sample.reverse === 'shuffle') {
            buff.reverse = (Math.random() > 0.5);
          } else {
            buff.reverse = sample.reverse;
          }

          buff.startTime =

          buff.fadeIn = 0.1;
          buff.fadeOut = 0.1;
          buff.startTime = sample.startTime;
          buff.endTime = sample.endTime;

          if(sample.fill) {
            let full_time = 60 / this.bpm;
            let fact = full_time /  (sample.endTime - sample.startTime);
            buff.playbackRate = fact * Math.round(Math.random() * 5);
          } else {
            buff.playbackRate = (Math.random() * sample.speed_range) + sample.min_speed;
          }

          this.buffers.push(buff);
        }
      },

      // Previewing
      playSample(sample) {
        // Playback one sample
        this.playback.src = URL.createObjectURL(this.samples[sample].sample);
        this.playback.currentTime = this.samples[sample].startTime;
        this.playback.play();

        console.log((this.samples[sample].endTime - this.samples[sample].startTime) * 1000);

        setTimeout(() => {
          this.playback.pause();
        }, (this.samples[sample].endTime - this.samples[sample].startTime) * 1000);
      },
      stopPlaySample() {
        // Stop playback of single sample
        this.playback.pause();
      },

      // BPM Tap
      tap() {
        clearTimeout(this.bpmResetSwitch);

        const stamp = new Date();
        const diff = Number(stamp - this.taps.abs[this.taps.amt - 1]);

        this.taps.abs.push(stamp);

        if(this.taps.amt === 1) {this.taps.total = diff;}
        else if(this.taps.amt > 1) {this.taps.total = this.taps.total + diff;}

        this.taps.amt++;
        this.calculateBPM();

        this.bpmResetSwitch = setTimeout(() => {
          this.resetTaps();
        }, 2000);
      },
      resetTaps() {
        this.taps = {abs: [], amt: 0, total: 0};
      },
      calculateBPM() {
        if(this.taps.amt > 1) {
          const avg = this.taps.total / this.taps.amt;
          const bpm = 60000 / avg;
          this.bpm = bpm.toFixed(2);
        }
      },

      // Effects
      updateReverbAmount() {
        this.reverb.roomSize.value = this.reverb_amount;
        //this.reverb.dampening.value = this.reverb_amount * 10000;
      },

      // Actual Looper handlers
      toggleLooping(sample_id) {
        this.samples[sample_id].looping = !this.samples[sample_id].looping;

        let current = this.buffers.filter(item => {
          return item.id === this.samples[sample_id].id;
        });

        for(let i = 0; i < current.length; i++) {
          current[i].looping = !current[i].looping;
          current[i].loop = current[i].looping;
        }
      }
    },
    watch: {
      lp_cutoff() {
        this.lp.frequency.value = this.lp_cutoff;
      },
      lp_res() {
        this.lp.Q.value = this.lp_res;
      }
    }
  }
</script>

<style scoped>

</style>