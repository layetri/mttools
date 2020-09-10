<!--suppress ALL -->
<template>
  <div class="mm-container p-4 bg-gray-200 flex flex-col">
    <div class="flex w-full flex-row">
      <div class="w-3/4 flex-auto">
        <h1 class="text-3xl font-light">Midi<span class="font-normal text-teal-400">Meet</span></h1>
      </div>
      <div class="flex-auto w-1/4 text-gray-600 align-middle" style="text-align: right;">
        <span v-if="user !== null && !editingUsername" @dblclick="editingUsername = true">
          {{ user.name }}
        </span>
        <span class="font-normal text-gray-700" v-if="key !== null">@ {{key}}</span>
        <input type="text" class="focus:outline-none focus:shadow-outline" v-if="editingUsername" v-model="user.name" placeholder="Username" @keypress.enter="changeNickname()">
      </div>
    </div>

    <div class="flex-auto">
      <div v-if="screen === 0">
        <div class="w-1/2 mx-auto py-10">
          <div class="w-1/2 float-left border-r-2 border-gray-300 p-5">
            <h5 class="font-light text-xl"><span class="font-normal text-teal-600">Join</span> a room</h5>
            <br>

            <div class="overflow-y-auto" style="max-height: 20vh">
              <div class="shadow border rounded w-full py-2 px-3 mb-1 text-gray-700 leading-tight bg-white cursor-pointer" v-for="item in rooms" @click="joinExisting(item.room)">{{item.room}}</div>
            </div>

            <br>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="key">
              Room key
            </label>
            <input class="focus:outline-none focus:shadow-outline mb-4" id="key" type="text" placeholder="aBC1d2" v-model="key">
            <button class="btn" @click="join()">Join</button>
          </div>
          <div class="w-1/2 float-left p-5">
            <h5 class="font-light text-xl"><span class="font-normal text-teal-600">Create</span> a room</h5>
            <br>
            <button class="btn" @click="join()">Create</button>
          </div>
        </div>
      </div>

      <div v-if="screen === 1">
        <div class="text-center">
          <h1 class="text-3xl">Hurray!</h1>
          <p>Your room has been created! Send the code below to your friends so they can join.</p>
          <br>
          <div class="shadow border mx-auto rounded md:w-1/4 py-2 px-3 mb-1 text-2xl text-gray-700 leading-tight bg-white cursor-pointer">{{key}}</div>
          <br>
          <button class="btn" @click="screen = 2">Done!</button>
        </div>
      </div>

      <div v-if="screen === 2" class="h-full">
        <div class="flex h-full">
          <div class="flex items-stretch flex-wrap flex-col w-1/4">
            <div class="card w-full mb-4">
              <p v-for="peer in peers">{{peer.name}}</p>
            </div>
            <!-- Chat -->
            <div class="card w-full flex-grow flex-1">
              <div class="flex flex-col">
                <h5 class="text-xl font-light flex-grow-0">Chat</h5>

                <div :style="{height: 'calc(80vh - '+peers.length * 20+'px - 12rem)'}" class="overflow-y-auto" id="chatscroll">
                  <div v-for="msg in messages">
                    <span class="text-xs text-gray-400 font-normal mb-1" v-html="msg.user.name"></span>
                    <div v-html="msg.message" class="msg text-base rounded shadow py-2 px-3 mb-2" :class="[msg.user.id === user.id ? 'bg-gray-300 text-gray-700' : 'bg-teal-400 text-white']"></div>
                  </div>
                </div>

                <input class="flex-grow-0" type="text" v-model="message" placeholder="Type a message..." @keypress.enter="sendMessage()">
              </div>
            </div>
          </div>

          <div class="flex items-stretch flex-wrap flex-col w-3/4 px-2" id="midi-container" @drop.prevent="loadMidi" @dragover.prevent>
            <div v-if="toggleEditor" class="flex-auto flex-col">
              <div class="w-full p-2 flex-grow-0 align-middle inline-flex">
                <i class="material-icons text-gray-600 cursor-pointer" @click="backToClips()">apps</i>
                <span class="text-gray-600 cursor-pointer" @click="togglePlayState()">
                  <i class="material-icons" v-if="!playing">play_arrow</i>
                  <i class="material-icons" v-else>pause</i>
                </span>
                <input type="number" class="text-xs" id="bpm-input" style="width: 4rem" v-model="bpm" @keydown.enter="newBpm()" @blur="newBpm()" placeholder="bpm">

                <i class="material-icons text-gray-600 cursor-pointer" @click="zoom('in')">zoom_in</i>
                <i class="material-icons text-gray-600 cursor-pointer" @click="zoom('out')">zoom_out</i>
              </div>

              <div class="key-container rounded shadow relative overflow-x-auto overflow-y-hidden w-100 flex flex-row">
                <div class="keys border-r rounded-l border-gray-400">
                  <div class="key" :class="determineKeyClass(key, 'key')+[keyList.indexOf(key) === 0 ? ' rounded-tl' : '']+[keyList.indexOf(key) === keyList.length - 1 ? ' rounded-bl' : '']" :style="{height: noteHeight}" v-for="key in keyList"></div>
                </div>

                <div class="timer-track absolute" id="timerTrack" :style="{width: timerArray[0].width * timerArray.length}">
                  <div v-for="subd in timerArray" :style="{width: subd.width, marginLeft: subd.width * timerArray.indexOf(subd)}" class="absolute">{{subd.num}} {{subd.unit}}</div>
                </div>

                <div class="piano-roll">
                  <div class="playhead absolute" :style="{marginLeft: playheadPos}"></div>

                  <div class="midi-grid" :style="{width: $('#midi-container').width() - 50}">
                    <div :class="determineKeyClass(key, 'bg')" :style="{height: noteHeight, width: $('#midi-container').width() - 50}" v-for="key in keyList"></div>
                  </div>

                  <div class="time-grid">
                    <div v-for="subd in timerArray" :style="{width: subd.width, marginLeft: subd.width * timerArray.indexOf(subd)}" class="absolute time-marker"></div>
                  </div>

                  <div class="note-overlay">
                    <div class="note bg-teal-400 absolute border border-gray-500" :style="{width: calcNoteWidth(note), marginTop: calcNoteMarginTop(note), marginLeft: calcNoteMarginLeft(note), height: noteHeight}" v-for="note in clips[selClip].notes">

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex flex-col" v-else>
              <div class="w-full p-2 flex-grow-0">
                <input type="number" class="text-xs" id="bpm-input" style="width: 4rem" v-model="bpm" @keydown.enter="newBpm()" @blur="newBpm()" placeholder="bpm">
              </div>
              <div class="flex flex-row flex-wrap">
                <div class="p-1 w-1/4" v-for="item in clips">
                  <div class="card w-full">
                    <div class="mb-2">
                      <div>
                        <h5 class="font-normal text-xl text-gray-700" @dblclick="() => {editClipName = item.id; clipRename = item.name}" v-if="!editClipName">{{ item.name || "Clip" }}</h5>
                        <input type="text" v-if="editClipName === item.id" v-model="clipRename" @keypress.enter="renameClip(item.id)">
                      </div>
                      <span class="text-xs uppercase font-light text-gray-500">{{ item.instrument }}</span>
                    </div>

                    <div class="bg-gray-200 p-2 rounded mb-2">
                      <span v-for="usr in getClipUsers(clips.indexOf(item))">{{usr.name}}</span>
                    </div>

                    <div class="w-full cursor-pointer btn text-center" @click="openEditor(clips.indexOf(item))">Open</div>
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
    name: "MidiMeet",
    data() {
      return {
        screen: 0,
        key: null,
        channel: null,
        rooms: null,
        clips: [],
        selClip: null,
        part: null,
        user: null,
        peers: [],
        updateInterval: null,
        playheadPos: '0px',
        editingUsername: false,
        toggleEditor: false,
        editClipName: false,
        currentNote: null,
        clipRename: null,
        messages: [],
        message: null,
        dropfile: null,
        bpm: 120,
        sigUpper: 4,
        sigLower: 4,
        masterCtx: null,
        synth: null,
        playing: false,
        magFactorX: 1.0,
        magFactorY: 1.0,
        noteHeight: null,
        editorYRange: [21, 108],
        metro: null
      }
    },
    mounted() {
      axios.get('/midimeet/init').then(res => {
        if(res.data.exist) {
          this.user = res.data.user;
          this.rooms = res.data.rooms;
        }
      });
    },
    methods: {
      joinExisting(room) {
        this.key = room;
        this.join();
      },
      join() {
        axios.post('/midimeet/join', {
          room: this.key
        }).then(res => {
          if(this.key === null) {
            this.screen = 1;
            this.key = res.data.room;
            this.user = res.data.user;
          } else {
            if(this.user === null) {
              this.user = res.data.user;
            }
            this.screen = 2;
          }

          this.channel = Echo.private('midimeet.'+res.data.room)
            .listenForWhisper('changeNickname', e => {
              this.filterPeers(e.user.id)[0].name = e.user.name;
            })
            .listenForWhisper('welcomeUser-'+this.user.id, e => {
              if(this.clips.length === 0) {
                this.clips = e.clips;
              }
              if(this.messages.length === 0) {
                this.messages = e.messages;
              }
            })
            .listenForWhisper('createClip', e => {
              this.clips.push(e.clip);
            })
            .listenForWhisper('addNote', e => {

            })
            .listenForWhisper('userEnteredEditor', e => {
              this.filterPeers(e.user)[0].clip = e.clip;
              this.$forceUpdate();
            })
            .listenForWhisper('userBackHome', e => {
              this.filterPeers(e.user)[0].clip = null;
              this.$forceUpdate();
            })
            .listenForWhisper('renameClip', e => {
              this.clips.filter(clip => {
                return clip.id === e.clip;
              })[0].name = e.name;
            })
            .listenForWhisper('newBpm', e => {
              this.bpm = e.bpm;
              Tone.Transport.bpm.value = this.bpm;
            })
            .listenForWhisper('sendMessage', e => {
              this.messages.push({message: e.message, user: e.user});
              let elem = document.getElementById('chatscroll');
              elem.scrollTop = elem.scrollHeight;
            });

          Echo.join('midimeetpr.'+res.data.room)
            .here((users) => {
              this.peers = users;
            }).joining((user) => {
              this.peers.push(user);
              if(this.peers.indexOf(this.filterPeers(this.user.id)[0]) === 0) {
                this.channel.whisper('welcomeUser-'+user.id, {
                  clips: this.clips,
                  messages: this.messages
                });
              }
            }).leaving((user) => {
              let ind = this.peers.indexOf(this.filterPeers(user.id)[0]);
              this.peers.splice(ind, 1);
            });

          const foo = async () => {
            await Tone.start();
            Tone.Transport.bpm.value = this.bpm;
            Tone.Transport.timeSignature = [this.sigUpper, this.sigLower];
          };

          foo();
        });
      },
      // User stuff
      changeNickname() {
        axios.post('/midimeet/change-nickname', {
          name: this.user.name
        }).then(res => {
          if(this.key !== null) {
            this.channel.whisper('changeNickname', {
              user: this.user
            });
          }
          this.editingUsername = false;
        });
      },
      filterPeers(id) {
        return this.peers.filter(peer => {
          return peer.id === id;
        });
      },

      //Clips stuff
      renameClip(clip) {
        let name = this.clipRename;

        this.clips.filter(clp => {
          return clp.id === clip;
        })[0].name = name;

        this.channel.whisper('renameClip', {
          clip: clip,
          name: name
        });

        this.clipRename = null;
        this.editClipName = false;
      },

      // Chat stuff
      sendMessage() {
        this.channel.whisper('sendMessage', {
          user: this.user,
          message: this.message
        });

        this.messages.push({message: this.message, user: this.user});
        this.message = null;
      },

      // Midi stuff
      async loadMidi(e) {
        let files = e.dataTransfer.files || e.target.files;
        if(!files) return;

        for(let i = 0; i < files.length; i++) {
          if(files[i].type === 'audio/midi' || files[i].type === 'audio/x-midi') {
            let fileurl = URL.createObjectURL(files[i]);
            const midi = await Midi.fromUrl(fileurl);

            midi.tracks.forEach(track => {
              let notes = [];
              track.notes.forEach(note => {
                let dur = Tone.Time(note.duration).toNotation();
                let len = note.duration * 1000; // length in ms
                notes.push({note: note.name, time: note.time, duration: dur, len: len, velocity: note.velocity, midi: note.midi});
              });

              let id;
              do {
                id = Math.floor(Math.random() * 10000);
              } while(this.clips.filter(clip => {
                return clip.id === id;
              }).length > 0);

              let len = (midi.duration * 1000) / (60000 / this.bpm);

              let clip = {name: track.name, notes: notes, id: id, len: len};
              this.clips.push(clip);
              this.channel.whisper('createClip', {
                clip: clip
              });
            });
          }
        }
      },
      openEditor(clip) {
        this.selClip = clip;

        Tone.Transport.bpm.value = this.bpm;

        this.synth = new Tone.PolySynth(6, Tone.Synth).toMaster();
        this.clips[this.selClip].instrument = 'Synth';

        this.channel.whisper('userEnteredEditor', {
          clip: this.clips[this.selClip].id,
          user: this.user.id
        });

        this.part = new Tone.Part((time, val) => {
          this.currentNote = val.midi;
          this.synth.triggerAttackRelease(val.note, val.duration, time, val.velocity);
        }, this.clips[this.selClip].notes).start(0);

        this.toggleEditor = true;
        this.calcNoteHeight();
      },
      backToClips() {
        this.toggleEditor = false;
        Tone.Transport.stop();

        this.playing = false;

        this.magFactorX = 1;
        this.magFactorY = 1;

        this.channel.whisper('userBackHome', {
          user: this.user.id
        });
      },
      togglePlayState() {
        Tone.Transport.toggle();

        if(!this.playing) {
          this.metro = new Tone.Synth({oscillator: {type: 'pulse'}, envelope: {release: 0.1}}).toMaster();
          Tone.Transport.scheduleRepeat(() => {
            this.metro.triggerAttackRelease("A5", "64n");
          }, "4n");

          this.updateInterval = setInterval(() => {
            this.schedulePlayhead();
          }, 50);
        } else {
          clearInterval(this.updateInterval);
        }
        this.playing = !this.playing;
      },
      zoom(dir) {
        if(dir === 'in') {
          if(this.magFactorX - 1 > 1) {
            this.magFactorX -= 1;
          } else {
            this.magFactorX = Math.round((this.magFactorX - 0.1) * 10) / 10;
          }
        } else if(dir === 'out') {
          if(this.magFactorX > 1) {
            this.magFactorX += 1;
          } else {
            this.magFactorX = Math.round((this.magFactorX + 0.1) * 10) / 10;
          }
        }
      },

      // Scheduler stuff
      newBpm() {
        document.getElementById('bpm-input').blur();
        Tone.Transport.bpm.value = this.bpm;

        this.channel.whisper('newBpm', {
          bpm: this.bpm
        });
      },
      schedulePlayhead() {
        const cur = Tone.Transport.seconds * 1000;
        let w = $('#timerTrack').width();
        let viewLength = this.getContainingMeasures(this.clips[this.selClip].len) * ((60000 / this.bpm) * this.sigUpper) * this.magFactorX;

        this.playheadPos = ((cur / viewLength) * w)+'px';
      },

      // Helpers
      getClipUsers(clip) {
        return this.peers.filter(peer => {
          return peer.clip === this.clips[clip].id;
        });
      },
      noteLen(notation) {
        return Tone.Time(notation).toTicks();
      },
      calcNoteMarginTop(note) {
        return (((this.editorYRange[1] + 1) - note.midi) * this.noteHeight * this.magFactorY)+'px';
      },
      calcNoteMarginLeft(note) {
        // 120 BPM
        // 1 beat = 500ms
        // 500ms = 192 ticks
        // (time * (60000 / bpm)) / 192
        let w = this.timerArray[0].width * this.timerArray.length;
        let t = Tone.Time(note.time).toTicks() / 192;
        return ((t / this.clips[this.selClip].len) * w / this.magFactorX)+'px';
      },
      calcNoteWidth(note) {
        let w = this.timerArray[0].width * this.timerArray.length;
        let l = Tone.Time(note.duration).toTicks() / 192; //length in beats
        let r = Math.ceil(((l / this.clips[this.selClip].len) * w / this.magFactorX))+'px';
        return r;
      },
      calcNoteHeight() {
        let h = $('#midi-container').height();
        let range = (this.editorYRange[1] + 1) - this.editorYRange[0];
        this.noteHeight = h / range;
      },
      getContainingMeasures(beats) {
        return Math.ceil(beats / this.sigUpper);
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

        if(len > 4 || this.sigUpper > 8 || this.magFactorX > 3) {
          let w = Math.ceil((len / this.clips[this.selClip].len) * xFull / this.magFactorX);
          for(let i = 0; i < len; i++) {
            arr.push({unit: 'm', width: w, num: i + 1});
          }
        } else {
          let w = Math.ceil(((len * this.sigUpper) / this.clips[this.selClip].len) * xFull / this.magFactorX);
          for(let i = 0; i < len; i++) {
            arr.push({unit: 'n', width: w, num: i + 1});
          }
        }

        return arr;
      }
    },
    updated() {
      if(this.screen === 2) {
        let elem = document.getElementById('chatscroll');
        elem.scrollTop = elem.scrollHeight;
      }
    },
    destroyed() {
      Echo.leave('midimeetpr.'+res.data.room);
    }
  }
</script>

<style scoped>
  .mm-container {
    height: 80vh;
  }
  #midi-container {
    height: calc(80vh - 8.25rem);
  }
  .key-container {
    height: calc(80vh - 8.25rem);
    padding-left: 50px;
  }
  .key-container::-webkit-scrollbar-track {
    background: transparent;
  }

  .time-marker {
    border-left: 1px solid blue;
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
    height: calc(80vh - 8.25rem);
  }
  .note-overlay {
    overflow-x: auto;
    width: 100%;
    z-index: 2;
  }
  .playhead {
    height: calc(80vh - 8.25rem);
    width: 1px;
    background-color: red;
    z-index: 1;
  }
  .keys {
    z-index: 2;
    margin-left: -50px;
    position: fixed;
  }
  .key {
    width: 50px;
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