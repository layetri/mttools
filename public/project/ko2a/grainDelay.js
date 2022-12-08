import Tone from 'tone'

export class GrainDelay {
  constructor(destination) {
    // Initialize output node
    this.node = new Tone.Gain(0.1).connect(destination);
    this.samplerate = 44100;

    this.writeBuff = new Tone.Buffer();
    this.readBuff = new Float32Array(this.samplerate);
    this.playBuff = new Tone.BufferSource(this.writeBuff);

    this.iterator = 0;
    this.samplecount = 0;
    this.playbackIterator = 0;
    this.loop = false;

    this.init();
  }
  init() {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      navigator.mediaDevices.getUserMedia ({audio: true}).then(stream => {
        this.perm = true;
        this.recorder = new MediaRecorder(stream);

        this.recorder.ondataavailable = async e => {
          await e.data.arrayBuffer().then(res => {
            let arr = new Uint8Array(res);
            let date = Date.now();
            console.log(arr);

            let test = [];

            // Get the duration of the recording
            let timeFactor = (date - this.startTime) / 1000;

            // Calculate the average distance between the recorded values, which will be used for interpolation
            let increment = Math.floor(this.samplerate / arr.byteLength);
            let pos = 0;

            // Loop over every spot in the buffer
            for (let i = 0; i < (this.samplerate * timeFactor); i ++) {
              let val = 0;
              // Calculate the distance from the last known sample
              let offset = i % increment;
              // If the offset is 0, add the known sample to the buffer
              if(!offset) {
                val = (arr[pos] - 128) / 128.0;
                pos++;
              }
              // Else, interpolate between the last and the next sample
              else {
                let last = arr[pos - 1];
                let next = arr[pos];
                // Generate the value
                val = last + (((next - last) / increment) * offset);
                let intermediate_val = val;
                val = (val - 128.0) / 128.0;
                test.push(val);

                //val = Number(val.toFixed(2));

                // Test logging
                if(i < 10) {
                  console.log({
                    next: next,
                    last: last,
                    value: val,
                    nextMinusLast: next - last,
                    increment: increment,
                    offset: offset,
                    intermediate_val: intermediate_val
                  });
                }
              }

              // Write the resulting value to the buffer
              if(i < 10) {
                console.log(val);
              }
              this.readBuff.set([val], this.iterator);
              // Increase the sample count
              this.samplecount++;

              // Test logging
              if(i < 10) {
                console.log('item at '+this.iterator+':'+this.readBuff[this.iterator]);
              }

              // Keep iterating if the buffer isn't full, else reset
              if (this.samplecount % this.readBuff.length) {
                this.iterator++;
              } else {
                this.iterator = 0;
              }
            }

            // Log the buffer
            console.log(this.readBuff);
            console.log(test);
            this.startTime = date;

            this.writeBackToBuffer();
          });
        }
      }).catch(error => {
        console.log('The following getUserMedia error occurred: ' + error);
      });
    } else {
      console.log('getUserMedia not supported on your browser!');
    }
  }
  recordToBuffer() {
    console.log(Tone.context.rawContext.sampleRate);
    this.recorder.start(1000);
    this.startTime = Date.now();
  }
  pitchDown() {
    for(let i = 0; i < this.readBuff.length; i++) {
      if(i % 2) {
        this.readBuff[i] = 0;
      }
    }
  }
  async writeBackToBuffer() {
    await this.writeBuff.fromArray(this.readBuff);
    this.playBuff = new Tone.BufferSource({buffer: this.writeBuff.get(), loop: true}).connect(this.node);
  }
  playBuffer() {
    this.playBuff.start(Tone.Time.now);
  }
  stopBuffer() {
    this.playBuff.stop();
    this.writeBackToBuffer().then(r => {
      console.log('rewritten');
    });
  }
  sineWaveGen() {
    function sinewave(x) {
      return Math.sin(x);
    }

    let frequency = 440;
    let rate = 44100;
    let period = rate / frequency;

    for(let i = 0; i < rate; i++) {

    }
  }
}