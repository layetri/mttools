import Tone from 'tone';

export class ComplexDelay {
  constructor(destination) {
    // Set parameters
    this.rightDelay = 0.1;
    this.leftDelay = 0.05;
    this.leftFilterFrequency = 750;
    this.rightFilterFrequency = 750;

    // Initialize output node
    this.node = new Tone.Gain(0.1).connect(destination);
    this.left = new Tone.Panner(-1).connect(this.node);
    this.right = new Tone.Panner(1).connect(this.node);

    this.src = new Tone.Gain();

    // Initialize main delay nodes
    this.delayNodeRight = new Tone.Delay(this.rightDelay, 5);
    this.delayNodeLeft = new Tone.Delay(this.leftDelay, 5);

    // Initialize left and right low pass filter
    this.filterNodeRight = new Tone.Filter(this.rightFilterFrequency, 'lowpass', -24)
        .connect(this.delayNodeRight);
    this.filterNodeLeft = new Tone.Filter(this.leftFilterFrequency, 'lowpass', -24)
        .connect(this.delayNodeLeft);


    // Initialize left and right feedback
    this.feedbackNodeRight = new Tone.Gain(0).connect(this.filterNodeRight);
    this.feedbackNodeLeft = new Tone.Gain(0).connect(this.filterNodeLeft);

    // Initialize left and right crossfeed
    this.crossfeedNodeRight = new Tone.Gain(0).connect(this.left);
    this.crossfeedNodeLeft = new Tone.Gain(0).connect(this.right);

    // Connect the main nodes
    this.delayNodeRight.fan(this.right, this.feedbackNodeRight, this.crossfeedNodeRight);
    this.delayNodeLeft.fan(this.left, this.feedbackNodeLeft, this.crossfeedNodeLeft);
    this.src.fan(this.delayNodeLeft, this.delayNodeRight);
  }

  // Collection method to ease parameter manipulation
  set(parameter, side, value) {
    console.log('setting '+parameter+' on '+side+' to: '+value);
    if(value < 1.0 && value > 0.0) {
      // Collection for feedback
      if (parameter === 'feedback') {
        if (side === 'left') {
          this.feedbackNodeLeft.gain.value = value;
        } else if (side === 'right') {
          this.feedbackNodeRight.gain.value = value;
        }
      }
      // Collection for crossfeed
      else if (parameter === 'crossfeed') {
        if (side === 'left') {
          this.crossfeedNodeLeft.gain.value = value;
        } else if (side === 'right') {
          this.crossfeedNodeRight.gain.value = value;
        }
      }

      // Collection for delay time
      else if (parameter === 'delay_time') {
        if (side === 'left') {
          this.delayNodeLeft.delayTime.value = value;
        } else if (side === 'right') {
          this.delayNodeRight.delayTime.value = value;
        }
      }

    }
  }
}