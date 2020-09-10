<!--suppress ALL -->
<template>
  <div class="mm-container p-4 bg-gray-200 flex flex-col">
    <div class="flex-auto">

      <div class="h-full">
        <div class="flex h-full">
          <div class="flex items-stretch flex-wrap flex-col w-3/4 px-2" id="midi-container" @drop.prevent="loadMidi" @dragover.prevent>
            <div class="flex-auto flex-col">
              <div class="w-full p-2 flex-grow-0 align-middle inline-flex flex">
                <div class="flex-auto flex-grow">
                  <i class="material-icons text-gray-600 cursor-pointer no-select" @click="backToClips()">apps</i>

                  <span class="text-gray-600 cursor-pointer no-select" @click="togglePlayState()">
                    <i class="material-icons" v-if="!playing">play_arrow</i>
                    <i class="material-icons" v-else>stop</i>
                  </span>

                  <input type="number" class="text-xs" id="bpm-input" style="width: 4rem" v-model="bpm" @keydown.enter="$refs.bpmInput.blur()" @blur="newBpm()" ref="bpmInput" placeholder="bpm" min="1" max="300">

                  <i class="material-icons text-gray-600 cursor-pointer no-select" @click="zoom('in')">zoom_in</i>
                  <i class="material-icons text-gray-600 cursor-pointer no-select" @click="zoom('out')">zoom_out</i>

                  <span class="text-gray-600 cursor-pointer no-select" @click="addMeasure()">+ measure</span>
                </div>

                <div class="quantise-buttons flex-grow-0">
                  <div class="border-2 border-teal-500 float-left p-2 text-xs no-select cursor-pointer" v-for="(quantise, val) in units" :class="[unit === val ? 'bg-teal-300 text-white' : 'bg-white text-gray-600']+[val === '1m' ? ' border-l-2' : ' border-l-0']" @click="unit = val">{{quantise}}</div>
                </div>
              </div>

              <div class="key-container rounded shadow relative overflow-x-auto overflow-y-hidden w-100 flex flex-row" id="keyContainer">
                <div class="keys border-r rounded-l border-gray-400">
                  <div class="key" :class="determineKeyClass(key, 'key')+[keyList.indexOf(key) === 0 ? ' rounded-tl' : '']+[keyList.indexOf(key) === keyList.length - 1 ? ' rounded-bl' : '']" :style="{height: noteHeight+'px'}" v-for="key in keyList"></div>
                </div>

                <div id="timekeeper" class="absolute" :style="{width: (timerArray[0].width * timerArray.length)+'px'}"></div>

                <div class="timer-track" id="timerTrack" :style="{width: timerArray[0].width * timerArray.length}">
                  <div v-for="subd in timerArray" :style="{width: subd.width+'px', marginLeft: (subd.width * timerArray.indexOf(subd))+'px'}" class="absolute pl-1 text-sm text-gray-600 uppercase no-select cursor-pointer" @click="setStartPos()">
                    <span v-if="division >= 1 && subd.num % (division * sigUpper) === 1" v-html="Math.floor(subd.num / (division * sigUpper)) + 1"></span>
                    <span v-else-if="division < 1" v-html="subd.num"></span>
                  </div>
                </div>

                <div class="piano-roll">
                  <div class="playhead absolute" :style="{marginLeft: playheadPos+'px'}"></div>

                  <div class="midi-grid" :style="{width: $('#midi-container').width() - 50}" @click="handleGridEvent($event, 'click')" @drag.prevent="handleGridEvent($event, 'drag')" @dragstart="handleGridEvent($event, 'dragstart')" @dragend="handleGridEvent($event, 'dragend')">
                    <div :class="determineKeyClass(key, 'bg')" :style="{height: noteHeight+'px', width: ($('#midi-container').width() - 50)+'px'}" v-for="key in keyList"></div>
                  </div>

                  <div class="time-grid">
                    <div v-for="subd in timerArray" :style="{marginLeft: (subd.width * timerArray.indexOf(subd))+'px', borderLeftWidth: [timerArray.indexOf(subd) % (division * sigUpper) === 0 ? '2px' : '1px']}" class="absolute time-marker border-gray-300"></div>
                  </div>

                  <div class="note-overlay">
                    <div class="note absolute"
                         :style="{width: calcNoteWidth(note), marginTop: calcNoteMarginTop(note), marginLeft: calcNoteMarginLeft(note), height: noteHeight+'px'}"
                         v-for="note in clips[selClip].notes">
                      <div class="note-node border border-gray-500 cursor-pointer"
                           :class="[selectedNotes.includes(clips[selClip].notes.indexOf(note)) ? 'bg-pink-400' : 'bg-teal-400']"
                           @mousedown="handleNoteEvent(note, 'down')"
                           @dragstart="handleNoteEvent($event, 'dragstart')"
                           @dragend="handleNoteEvent(note, 'dragend', $event)"
                           @mouseup=""
                           draggable>
                      </div>
                      <div class="resize-hitbox"
                           @dragstart="handleNoteEvent(note, 'resize-start', $event)"
                           @drag.prevent="handleNoteEvent(note, 'resize', $event)"
                           @dragend="handleNoteEvent(note, 'resize-end', $event)" draggable></div>
                    </div>
                    <div class="ghostnote absolute bg-pink-200" :style="{width: calcNoteWidth(ghost), marginTop: calcNoteMarginTop(ghost), marginLeft: calcNoteMarginLeft(ghost), height: noteHeight+'px'}" v-for="ghost in ghostnotes"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import * as Tone from "tone";
  import { Midi } from '@tonejs/midi';

  export default {
    name: "Editor",
    data() {
      return {
        screen: 0,
        key: null,
        clips: [],
        selClip: null,
        part: null,
        colors: ['red', 'green', 'blue', 'yellow', 'teal', 'cyan'],

        updateInterval: null,
        playheadPos: '0px',
        selectedNotes: [],
        ghostnotes: [],
        resizing: false,
        selectBox: [[0,0],[0,0]],
        //tools: select, drag, pencil
        tool: 'select',
        clicks: 0,
        clickTime: null,
        dragTime: null,
        modifierKeys: {shift: false, ctrl: false, alt: false, cmd: false},
        unit: '4n',
        units: {'1m': 'Measure', '4n': '4th', '8n': '8th', '16n': '16th', '32n': '32nd'},

        toggleEditor: false,
        editClipName: false,
        clipRename: null,

        // Editor prefs
        metroEnable: false,

        dropfile: null,

        bpm: 120,
        sigUpper: 4,
        sigLower: 4,
        currentNote: null,

        masterCtx: null,
        synth: null,

        playing: false,

        magFactorX: 1.0,
        editorYRange: [21, 108],
        metro: null,
        ppq: 192
      }
    },
    mounted() {
      window.addEventListener('keypress', e => {
        if(this.toggleEditor) {
          this.shortkey(e.keyCode, e);
        }
      });

      window.addEventListener('keydown', e => {
        if(this.toggleEditor) {
          if(e.keyCode === 16) {
            this.modifierKeys.shift = true;
          } else if(e.keyCode === 17) {
            this.modifierKeys.ctrl = true;
          } else if(e.keyCode === 18) {
            this.modifierKeys.alt = true;
          } else if(e.metaKey) {
            this.modifierKeys.cmd = true;
          }
        }
      });

      window.addEventListener('keyup', e => {
        if(this.toggleEditor) {
          if(e.keyCode === 16) {
            this.modifierKeys.shift = false;
          } else if(e.keyCode === 17) {
            this.modifierKeys.ctrl = false;
          } else if(e.keyCode === 18) {
            this.modifierKeys.alt = false;
          } else if(e.metaKey) {
            this.modifierKeys.cmd = false;
          }
        }
      });
    },
    methods: {
      //Clips stuff
      renameClip(clip) {
        let name = this.clipRename;

        this.clips.filter(clp => {
          return clp.id === clip;
        })[0].name = name;

        this.clipRename = null;
        this.editClipName = false;
      },
      async loadMidi(e) {
        let files = e.target.files || e.dataTransfer.files;
        if(!files) return;

        for(let i = 0; i < files.length; i++) {
          if(files[i].type === 'audio/midi' || files[i].type === 'audio/x-midi') {
            let fileurl = URL.createObjectURL(files[i]);
            const midi = await Midi.fromUrl(fileurl);

            midi.tracks.forEach(track => {
              let notes = [];
              track.notes.forEach(note => {
                notes.push({note: note.name, time: note.time, len: note.duration, velocity: note.velocity, midi: note.midi});
              });

              let id;
              do {
                id = Math.floor(Math.random() * 10000);
              } while(this.clips.filter(clip => {
                return clip.id === id;
              }).length > 0);

              // Length in beats
              let len = (midi.duration * 1000) / (60000 / this.bpm);

              let clip = {name: track.name, notes: notes, id: id, len: len};
              this.clips.push(clip);
            });
          }
        }
      },
      exportMidi() {
        let midi = new Midi();
        let fac = 480 / Tone.Transport.PPQ;

        for(let c = 0; c < this.clips.length; c++) {
          const track = midi.addTrack();
          for(let i = 0; i < this.clips[c].notes.length; i++) {
            let note = this.clips[c].notes[i];
            let time = Tone.Time(note.time).toTicks() * fac;
            console.log(time);
            track.addNote({midi: note.midi, ticks: time, duration: note.len, velocity: note.velocity});
          }
        }

        let filename = 'midimeet-'+this.key+'-'+new Date().toLocaleDateString('nl-NL')+'.mid';
        let contents = new Buffer(midi.toArray());
        console.log(midi);
        saveFile(filename, 'audio/midi', contents);

        function saveFile (name, type, data) {
          if (data !== null && navigator.msSaveBlob)
            return navigator.msSaveBlob(new Blob([data], { type: type }), name);
          var a = $("<a style='display: none;'/>");
          var url = window.URL.createObjectURL(new Blob([data], {type: type}));
          a.attr("href", url);
          a.attr("download", name);
          $("body").append(a);
          a[0].click();
          window.URL.revokeObjectURL(url);
          a.remove();
        }
      },
      addMeasure() {
        this.clips[this.selClip].len = this.clips[this.selClip].len + this.sigUpper;
      },

      // Editor stuff
      openEditor(clip) {
        this.selClip = clip;

        Tone.Transport.bpm.value = this.bpm;

        this.synth = null;
        this.synth = new Tone.PolySynth(12, Tone.Synth).toMaster();
        this.clips[this.selClip].instrument = 'Synth';

        if(this.metroEnable) {
          this.metronize();
        }

        this.part = null;
        this.part = new Tone.Part((time, val) => {
          this.currentNote = val.midi;
          this.synth.triggerAttackRelease(val.note, val.len, time, val.velocity);
        }, this.clips[this.selClip].notes).start(0);

        this.toggleEditor = true;
      },
      backToClips() {
        this.toggleEditor = false;
        Tone.Transport.stop();

        this.synth.releaseAll();

        this.playing = false;
        this.part.dispose();

        this.magFactorX = 1;
        this.magFactorY = 1;
      },
      togglePlayState() {
        Tone.Transport.toggle();

        if(!this.playing) {
          this.updateInterval = setInterval(() => {
            this.schedulePlayhead();
          }, 50);
        } else {
          clearInterval(this.updateInterval);
          this.synth.releaseAll();
        }
        this.playing = !this.playing;
      },
      toggleMetro() {
        if(this.metroEnable) {
          Tone.Transport.clear(this.metro);
        } else {
          this.metronize();
        }
        this.metroEnable = !this.metroEnable;
      },
      metronize() {
        let gain = new Tone.Gain(0.1);
        let synth = new Tone.Synth({
          oscillator: {type: 'pulse'},
          envelope: {release: 0.1}
        });
        synth.chain(gain, Tone.Master);

        Tone.Transport.scheduleOnce(() => {
          this.metro = Tone.Transport.scheduleRepeat(() => {
            synth.triggerAttackRelease("A5", "64n");
          }, "4n");
        }, '@4n');
      },
      zoom(dir) {
        if(dir === 'in') {
          this.magFactorX = this.magFactorX / 1.25;
        } else if(dir === 'out') {
          this.magFactorX = this.magFactorX * 1.25;
        }
      },
      newClip() {
        let id;
        do {
          id = Math.floor(Math.random() * 10000);
        } while(this.clips.filter(clip => {
          return clip.id === id;
        }).length > 0);

        let clip = {name: 'clip', notes: [], id: id, len: 16};
        this.clips.push(clip);
      },

      // Scheduler stuff
      newBpm() {
        this.changeBpm();
      },
      changeBpm() {
        let old = Tone.Transport.bpm.value;
        let arr = [];

        for(let c = 0; c < this.clips.length; c++) {
          for(let i = 0; i < this.clips[c].notes.length; i++) {
            let len = Tone.Time(this.clips[c].notes[i].len).toTicks()+'i';
            let time = Tone.Time(this.clips[c].notes[i].time).toTicks()+'i';

            arr.push({len: len, time: time, clip: c, note: i});
          }
        }
        Tone.Transport.bpm.value = this.bpm;

        for (let j = 0; j < arr.length; j++) {
          let len = Tone.Time(arr[j].len).toSeconds();
          let time = Tone.Time(arr[j].time).toSeconds();

          this.clips[arr[j].clip].notes[arr[j].note].len = len;
          this.clips[arr[j].clip].notes[arr[j].note].time = time;
        }
      },
      schedulePlayhead() {
        const cur = Tone.Transport.seconds * 1000;
        let w = $('#timekeeper').width();
        let viewLength = this.getContainingMeasures(this.clips[this.selClip].len) * ((60000 / this.bpm) * this.sigUpper) * this.magFactorX * this.division;

        this.playheadPos = ((cur / viewLength) * w) * this.division;
      },

      // UX
      shortkey(key, e) {
        if (key === 32) {
          this.togglePlayState();
        } else if((this.modifierKeys.ctrl || this.modifierKeys.cmd) && (key === 65 || key === 97 || key === 1)) {
          e.preventDefault();
          this.selectedNotes = [];
          for(let i = 0; i < this.clips[this.selClip].notes.length; i++) {
            this.selectedNotes.push(i);
          }
        }
      },
      handleGridEvent(e, type) {
        if(this.tool === 'select') {
          if(type === 'click') {
            this.clicks++;
            if(this.clicks === 1) {
              // Single click
              if(this.tool === 'select') {
                this.selectedNotes = [];
                this.clickTime = setTimeout(() => {
                  this.clicks = 0;
                }, 300);
              }
            } else {
              // Double click
              this.clicks = 0;
              if(this.tool === 'select') {
                let num = this.determineKeyAtPos(e.clientY);
                let t = this.determineTimeAtPos(e.clientX);

                let note = new Tone.Midi(num).toNote();
                let len = new Tone.Time(this.unit).toSeconds();

                let res = {len: len, midi: num, note: note, time: t, velocity: 0.8};
                this.clips[this.selClip].notes.push(res);

                this.part.add(t, res);
                clearTimeout(this.clickTime);
              }
            }
          }
        }
      },
      handleNoteEvent(note, type, e = null) {
        if (type === 'down') {
          this.clicks++;
          let ind = this.clips[this.selClip].notes.indexOf(note);
          if (this.clicks === 1) {
            // Single click
            if (this.tool === 'select') {
              if(!this.selectedNotes.includes(ind)) {
                if (!this.modifierKeys.shift) {
                  this.dragTime = setTimeout(() => {
                    this.selectedNotes = [];
                    this.selectedNotes.push(ind);
                  }, 50);
                } else {
                  this.selectedNotes.push(ind);
                }
              }

              this.clickTime = setTimeout(() => {
                this.clicks = 0;
              }, 300);

            }
          } else {
            // Double click
            this.clicks = 0;

            this.part.remove(note.time, note);
            this.clips[this.selClip].notes.splice(ind, 1);
          }
        }
        else if(type === 'dragstart') {
          clearTimeout(this.dragTime);
          // if(!this.selectedNotes.includes(this.clips[this.selClip].notes.indexOf(note))) {
          //   this.selectedNotes.push(this.clips[this.selClip].notes.indexOf(note));
          // }
        }
        else if(type === 'dragend') {
          // If the event is of type DragEnd
          // Calculate deltas and modify the affected notes
          let deltaTime = this.determineTimeAtPos(e.clientX) - note.time;
          let deltaKey = this.determineKeyAtPos(e.clientY) - note.midi;
          let arr = [];

          for(let i = 0; i < this.selectedNotes.length; i++) {
            let oldnote = this.clips[this.selClip].notes[this.selectedNotes[i]];

            let newKey = oldnote.midi + deltaKey;
            let note = new Tone.Midi(newKey).toNote();

            // Remove ToneJS event
            this.part.remove(oldnote.time, oldnote);

            // Prepare for broadcasting

            arr.push({oldKey: oldnote.midi, oldTime: oldnote.time, newNote: newKey, newTime: oldnote.time + deltaTime, index: this.selectedNotes[i], newLen: oldnote.len});

            // Update the note in the array
            this.clips[this.selClip].notes[this.selectedNotes[i]].midi = newKey;
            this.clips[this.selClip].notes[this.selectedNotes[i]].note = note;
            this.clips[this.selClip].notes[this.selectedNotes[i]].time += deltaTime;

            // Create a new ToneJS event
            this.part.add(this.clips[this.selClip].notes[this.selectedNotes[i]].time, this.clips[this.selClip].notes[this.selectedNotes[i]]);
          }
        }
        else if(type === 'resize-start') {
          this.resizing = true;
          if(!this.modifierKeys.shift) {
            this.selectedNotes = [];
          }
          if(!this.selectedNotes.includes(this.clips[this.selClip].notes.indexOf(note))) {
            this.selectedNotes.push(this.clips[this.selClip].notes.indexOf(note));
          }

          for(let i = 0; i < this.selectedNotes.length; i++) {
            let n = this.clips[this.selClip].notes[this.selectedNotes[i]];
            this.ghostnotes.push({midi: n.midi, len: n.len, time: n.time});
          }
        }
        else if(type === 'resize') {
          if(this.resizing) {
            let time = this.determineTimeAtPos(e.clientX, 'up') - note.time;

            for(let i = 0; i < this.ghostnotes.length; i++) {
              let deltaTime = time - this.ghostnotes[i].len;
              this.ghostnotes[i].len += deltaTime;
            }
          }
        }
        else if(type === 'resize-end') {
          if(this.resizing) {
            this.resizing = false;
            let arr = [];

            for(let i = 0; i < this.selectedNotes.length; i++) {
              let ghost = this.ghostnotes[i];
              let n = this.clips[this.selClip].notes[this.selectedNotes[i]];
              ghost.velocity = n.velocity;
              ghost.note = n.note;

              this.part.remove(n.time, n);
              this.clips[this.selClip].notes[this.selectedNotes[i]] = ghost;

              arr.push({oldKey: ghost.midi, oldTime: ghost.time, newNote: ghost.midi, newTime: ghost.time, index: this.selectedNotes[i], newLen: ghost.len});

              this.part.add(this.clips[this.selClip].notes[this.selectedNotes[i]].time, this.clips[this.selClip].notes[this.selectedNotes[i]]);
            }

            this.ghostnotes = [];
          }
        }
      },

      // Helpers
      noteLen(notation) {
        return Tone.Time(notation).toTicks();
      },
      calcNoteMarginTop(note) {
        return ((this.editorYRange[1] - note.midi) * this.noteHeight)+'px';
      },
      calcNoteMarginLeft(note) {
        // 120 BPM
        // 1 beat = 500ms
        // 500ms = 192 ticks
        // (time * (60000 / bpm)) / 192
        let w = this.timerArray[0].width * this.timerArray.length;
        let t = (Tone.Time(note.time).toTicks() / 192) * this.division; //length in beats
        return (((t / this.clips[this.selClip].len) / this.division) * w)+'px';
      },
      calcNoteWidth(note) {
        let w = this.timerArray[0].width * this.timerArray.length;
        let l = (Tone.Time(note.len).toTicks() / Tone.Time('4n').toTicks()) * this.division; //length in beats
        let r = Math.ceil(((l / this.clips[this.selClip].len) / this.division) * w)+'px';
        return r;
      },
      getContainingMeasures(beats) {
        return Math.ceil((beats / this.sigUpper));
      },
      determineKeyClass(key, mode) {
        let classes;

        if(key === this.currentNote && mode === 'key') {
          classes = 'bg-red-500';
        } else {
          if([1, 3, 6, 8, 10].includes((key) % 12)) {
            if(mode === 'key') {
              classes = 'bg-black';
            } else if(mode === 'bg') {
              classes = 'bg-gray-300';
            }
          } else {
            if(mode === 'key') {
              classes = 'bg-white';
            } else if(mode === 'bg') {
              classes = 'bg-gray-100';
            }
          }
        }

        return classes;
      },
      determineKeyAtPos(y) {
        let val = y - $('#keyContainer').offset().top;
        val = Math.round(($('#keyContainer').height() - val) / this.noteHeight) + this.editorYRange[0] - 1;

        return val;
      },
      determineTimeAtPos(x, dir = 'down') {
        let len = new Tone.Time(this.unit).toSeconds();
        let val = (x - $('#keyContainer').offset().left + 20) + $('#keyContainer').scrollLeft();

        if(dir === 'down') {
          val = Math.floor(val / this.timerArray[0].width) - Math.floor(this.division);
        } else if(dir === 'up') {
          val = Math.ceil(val / this.timerArray[0].width) - Math.floor(this.division);
        }

        val = (val * len);

        return val;
      },
      findClip(id) {
        return this.clips.filter(clip => {
          return clip.id === id;
        })[0];
      }
    },
    computed: {
      keyList() {
        let arr = [];
        for(let i = 0; i < ((this.editorYRange[1] + 1) - this.editorYRange[0]); i++) {
          arr.push(i + this.editorYRange[0]);
        }
        return arr.reverse();
      },
      timerArray() {
        let arr = [];
        let len = this.getContainingMeasures(this.clips[this.selClip].len);
        let xFull = $('#midi-container').width() - 50;

        let w = Math.ceil(((len / this.clips[this.selClip].len) * xFull) / this.sigUpper / this.division / this.magFactorX);

        for(let i = 0; i < len * this.sigUpper * this.division; i++) {
          arr.push({width: w, num: i + 1});
        }

        return arr;
      },
      noteHeight() {
        let h = $('#midi-container').height();
        let range = (this.editorYRange[1] + 1) - this.editorYRange[0];

        return (h / range);
      },
      division() {
        return new Tone.Time('4n').toTicks() / new Tone.Time(this.unit).toTicks();
      },
    },
    updated() {
      if(this.screen === 2) {
        let elem = document.getElementById('chatscroll');
        elem.scrollTop = elem.scrollHeight;
      }
    }
  }
</script>

<style scoped>
  .mm-container {
    height: 100vh;
  }
  #midi-container {
    height: calc(100vh - 8.25rem);
  }
  .key-container {
    height: calc(100vh - 8.25rem);
    padding-left: 50px;
  }
  .key-container::-webkit-scrollbar-track {
    background: transparent;
  }

  .time-marker {
    height: 100%;
  }

  .timer-track {
    z-index: 1;
  }

  .piano-roll {
    overflow: hidden;
  }
  .midi-grid {
    z-index: 0;
    position: fixed;
  }
  .time-grid {
    z-index: 1;
    position: absolute;
    height: calc(100vh - 8.25rem);
  }
  .note-overlay {
    overflow-x: auto;
    width: 100%;
    z-index: 100;
  }
  .note {
    z-index: 10;
  }
  .ghostnote {
    z-index: 5;
    cursor: ew-resize;
  }
  .note-node {
    width: 100%;
    height: 100%;
    z-index: 0;
  }
  .resize-hitbox {
    width: 5px;
    height: 100%;
    right: 0;
    top: 0;
    position: absolute;
    background-color: rgba(0,0,0,0.2);
    z-index: 10;
    cursor: ew-resize;
  }
  .playhead {
    height: calc(100vh - 8.25rem);
    width: 1px;
    background-color: red;
    z-index: 100;
  }
  .keys {
    z-index: 102;
    margin-left: -50px;
    position: fixed;
  }
  .key {
    width: 50px;
  }
  .no-select {
    user-select: none;
  }
  input {
    @apply shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight
  }
  .material-icons {
    @apply inline-flex align-middle py-2 px-1;
  }
  .card {
    @apply shadow border rounded py-2 px-3 leading-tight bg-white;
  }
  .msg {
    width: max-content;
  }
  .btn {
    @apply font-bold py-2 px-4 rounded bg-teal-400 text-white;
  }
  .btn:hover {
    @apply bg-teal-300;
  }
</style>