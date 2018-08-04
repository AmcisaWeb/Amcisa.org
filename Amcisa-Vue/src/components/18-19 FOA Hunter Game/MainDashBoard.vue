<template>
  <div style="background-color: black; width: 100%; position: relative; width: 100%; padding-top: 65.416%; z-index: -99">

    <img src="../../../src/assets/18-19_FOA_Hunter_Game/images/UI/Main.png" style="position: absolute; top:0px; left: 0px; width: 100%">

    <div v-if="currentCountDown!=0">
      <img  :src="require('../../../src/assets/18-19_FOA_Hunter_Game/images/UI/numbers/' + num[0] + '.png')" style="position: absolute; top:0.5%; left: 39%; width: 8%">
      <img  :src="require('../../../src/assets/18-19_FOA_Hunter_Game/images/UI/numbers/' + num[1] + '.png')" style="position: absolute; top:0.5%; left: 43%; width: 8%">
      <img  :src="require('../../../src/assets/18-19_FOA_Hunter_Game/images/UI/numbers/colon.png')" style="position: absolute; top:0.5%; left: 46%; width: 8%">
      <img  :src="require('../../../src/assets/18-19_FOA_Hunter_Game/images/UI/numbers/' + num[2] + '.png')" style="position: absolute; top:0.5%; left: 49%; width: 8%">
      <img  :src="require('../../../src/assets/18-19_FOA_Hunter_Game/images/UI/numbers/' + num[3] + '.png')" style="position: absolute; top:0.5%; left: 53%; width: 8%">
    </div>
    <div v-else>
      <img  :src="require('../../../src/assets/18-19_FOA_Hunter_Game/images/UI/End_Game.png')" style="position: absolute; top:1.5%; left: 36%; width: 28%">
    </div>

    <video autoplay muted loop style="position: absolute; top:2%; left: 0px; width: 100%; z-index: -5">
      <source src="../../../src/assets/18-19_FOA_Hunter_Game/videos/background.mp4" type="video/mp4"/>
    </video>

    <div>
      <span class="panel1" style=" top:25.1%; left: 31%;">{{panelData[0].survive}}</span>
      <span class="panel1" style=" top:36.2%; left: 31%;">{{panelData[0].cash}}</span>
      <span class="panel1" style=" top:47.3%; left: 31%;">{{panelData[0].backPack}}</span>
      <span class="panel1" style=" top:58.4%; left: 31%;">{{panelData[0].medKit}}</span>
      <span class="panel1" style=" top:69.5%; left: 31%;">{{panelData[0].fryingPan}}</span>
    </div>

    <div>
      <span class="panel2" style=" top:25.1%; left: 69%;">{{panelData[1].survive}}</span>
      <span class="panel2" style=" top:36.2%; left: 69%;">{{panelData[1].cash}}</span>
      <span class="panel2" style=" top:47.3%; left: 69%;">{{panelData[1].backPack}}</span>
      <span class="panel2" style=" top:58.4%; left: 69%;">{{panelData[1].medKit}}</span>
      <span class="panel2" style=" top:69.5%; left: 69%;">{{panelData[1].fryingPan}}</span>
    </div>

    <div style="position: absolute; top:120%;">
      <span>current countdown time: {{currentCountDown}}</span>
      <el-button @click="setCountdownTime">Set Countdown Time</el-button>
      <el-input placeholder="Time in Seconds" v-model="inputTime"></el-input>
      <br>
      <span>current round: {{currentRound}}</span>
      <el-button @click="setRound">Set Round Time</el-button>
      <el-input placeholder="Round number" v-model="inputRound"></el-input>
    </div>


  </div>
</template>

<script>
import axios from 'axios'
import Pusher from 'pusher-js'


export default {
  name: 'MainDashBoard',
  data() {
      return {
        panelData: [{
          cash: 0,
          survive: 0,
          backPack: 0,
          medKit:0,
          fryingPan:0
        }, {
          cash: 0,
          survive: 0,
          backPack: 0,
          medKit:0,
          fryingPan:0
        }],
        gameDuration: [720, 720, 900],
        currentRound: 1,
        currentCountDown: 0,
        baseNumberUrl: '../../../src/assets/18-19_FOA_Hunter_Game/images/UI/numbers/',
        num: [0,0,0,0],
        inputTime: '',
        inputRound: '',
        isCountingDown: false
      }
  },
  created () {
    axios.defaults.baseURL = this.$store.state.baseUrl

    this.updateInventory()
    this.updateTime()
    this.subscribe()
  },
  methods: {
    updateTime(){
      var axiosTime = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosTime.get('/api/18-19 FOA Hunter Game/GetTime')
        .then((response) => {
          var og1Time = response.data['og1']
          var og2Time = response.data['og2']
          this.panelData[0].survive = 0
          this.panelData[1].survive = 0
          og1Time.forEach((e) => {
            if(e.start_time!=null && e.end_time == null)
              this.panelData[0].survive ++
          })
          og2Time.forEach((e) => {
            if(e.start_time!=null && e.end_time == null)
              this.panelData[1].survive ++
          })
          this.$forceUpdate();
        })
        .catch((error) => {
          console.log(error)
        })
    },
    updateInventory(){
      var axiosInventory = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosInventory.get('/api/18-19 FOA Hunter Game/GetInventory')
        .then((response) => {
          this.panelData[0].cash = response.data[0]['cash']
          this.panelData[1].cash = response.data[1]['cash']

          this.panelData[0].backPack = response.data[0]['back_pack']
          this.panelData[0].medKit = response.data[0]['med_kit']
          this.panelData[0].fryingPan = response.data[0]['frying_pan']

          this.panelData[1].backPack = response.data[1]['back_pack']
          this.panelData[1].medKit = response.data[1]['med_kit']
          this.panelData[1].fryingPan = response.data[1]['frying_pan']

          this.$forceUpdate();
        })
        .catch((error) => {
          console.log(error)
        })
    },
    subscribe () {
      let pusher = new Pusher('e7fde66ab88312b757c3', { cluster: 'ap1' })
      pusher.subscribe('18-19_FOA_Hunter_Game')
      pusher.bind('PlayerStarted', data => {
        this.updateTime()
        if(this.isCountingDown == false)
        {
          this.isCountingDown = true
          this.startGame()
        }

      })
      pusher.bind('PlayerEnded', data => {
        this.updateTime()
        this.updateInventory()
      })
      pusher.bind('Purchased', data => {
        this.updateInventory()
      })
    },
    startGame(){
      this.currentCountDown = this.gameDuration[this.currentRound-1]
      this.$options.interval = setInterval(this.everyTick, 1000)
    },
    everyTick(){
      this.currentCountDown -= 1
      if(this.currentCountDown == 0){
        this.currentRound += 1;
        this.isCountingDown = false
        clearInterval(this.$options.interval)
      }
      var min = Math.floor(this.currentCountDown/60)
      var sec = this.currentCountDown%60
      this.num[0] = Math.floor(min/10)
      this.num[1] = min%10
      this.num[2] = Math.floor(sec/10)
      this.num[3] = sec%10
    },
    setCountdownTime(){
      this.currentCountDown = parseInt(this.inputTime)
    },
    setRound(){
      this.currentRound = parseInt(this.inputRound)
    },
    beforeDestroy () {
      clearInterval(this.$options.interval)
    }
  }
}
</script>

<style scoped>
  @font-face {
    font-family: 'Digital-7';
    src: url("../../../src/assets/fonts/digital-7.monoitalic.ttf");
  }
  th{
    border: 20px solid lightgray;
    background-color: #8cc5ff;
    border-radius: 75px;
    width: 100px;
  }

  .panel1{
    color: rgba(113, 132, 255, 1);
    font-size: 4vw;
    text-shadow: 0 0 10px rgb(40, 69, 255), 0 0 4px rgb(40, 69, 255);
    font-family: "Digital-7";
    position: absolute;
    -webkit-transform: translate(-50%, 0);
  }
  .panel2{
    color: rgba(255, 132, 113, 1);
    font-size: 4vw;
    text-shadow: 0 0 10px rgb(255, 69, 40), 0 0 4px rgb(255, 69, 40);
    font-family: "Digital-7";
    position: absolute;
    -webkit-transform: translate(-50%, 0);
  }
</style>
