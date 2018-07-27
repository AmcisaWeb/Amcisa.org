<template>
  <div>
    <div style="margin: 100px">
      <div width="20">
        <h5 style="alignment: left">OG1</h5>
      </div>
      <el-table
        :data=og1Time
        border
        style="width: 100%">
        <el-table-column
          prop="id"
          label="Player"
          width="180">
        </el-table-column>
        <el-table-column
          prop="start_time"
          label="Start Running Time">
        </el-table-column>
        <el-table-column
          prop="end_time"
          label="End Time">
        </el-table-column>
      </el-table>
      <div>
        <h5>Total Survive Time {{og1TotalSurviveTime}}</h5>
        <h5>Total Survive Time After Purchasing {{og1Cash}}</h5>
      </div>
    </div>
    <div style="margin: 100px">
      <div width="20">
        <h5 style="alignment: left">OG2</h5>
      </div>
      <el-table
        :data=og2Time
        border
        style="width: 100%">
        <el-table-column
          prop="id"
          label="Player"
          width="180">
        </el-table-column>
        <el-table-column
          prop="start_time"
          label="Start Running Time">
        </el-table-column>
        <el-table-column
          prop="end_time"
          label="End Time">
        </el-table-column>
      </el-table>
      <div>
        <h5>Total Survive Time {{og2TotalSurviveTime}}</h5>
        <h5>Total Survive Time After Purchasing {{og2Cash}}</h5>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Pusher from 'pusher-js'

export default {
  name: "TimeDashBoard",
  data () {
    return {
      og1Time: [],
      og2Time: [],
      og1Cash: 0,
      og2Cash: 0
    }
  },
  created () {
    axios.defaults.baseURL = this.$store.state.baseUrl
    this.updateTime()
    this.updateCash()
    this.subscribe()
  },
  methods: {
    updateTime() {
      var axiosTime = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosTime.get('/api/18-19 FOA Hunter Game/GetTime')
        .then((response) => {
          this.og1Time = response.data['og1']
          this.og2Time = response.data['og2']
        }).catch((error) => {
        console.log(error)
      })
    },
    updateCash() {
      var axiosInventory = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosInventory.get('/api/18-19 FOA Hunter Game/GetInventory')
        .then((response) => {
          this.og1Cash = response.data[0]['cash']
          this.og2Cash = response.data[1]['cash']
        }).catch((error) => {
        console.log(error)
      })
    },
    subscribe () {
      let pusher = new Pusher('e7fde66ab88312b757c3', { cluster: 'ap1' })
      pusher.subscribe('18-19_FOA_Hunter_Game')
      pusher.bind('PlayerStarted', data => {
        this.updateTime()
      })
      pusher.bind('PlayerEnded', data => {
        this.updateTime()
        this.updateInventory()
      })
      pusher.bind('Purchased', data => {
        this.updateInventory()
      })
    }

  },
  computed: {
    og1TotalSurviveTime: function () {
      var surviveSecond = 0
      var surviveTime = {
        'hour': 0,
        'min': 0,
        'sec': 0
      }
      this.og1Time.forEach(function (e) {
        if((e['start_time'] != null) && (e['end_time'] != null)){
          var StartTimeArr = e['start_time'].split(":")
          StartTimeArr.forEach(function (ee, index) {   //convert String to Int
            StartTimeArr[index] = parseInt(ee)
          })
          var StartSec = StartTimeArr[0]*3600 + StartTimeArr[1]*60 + StartTimeArr[2]
          var EndTimeArr = e['end_time'].split(":")
          EndTimeArr.forEach(function (ee, index) {   //convert String to Int
            EndTimeArr[index] = parseInt(ee)
          })
          var EndSec = EndTimeArr[0]*3600 + EndTimeArr[1]*60 + EndTimeArr[2]
          surviveSecond += EndSec - StartSec
          console.log(surviveSecond)
        }
      })
      surviveTime['hour'] = Math.floor(surviveSecond/3600)
      surviveSecond = surviveSecond%3600
      surviveTime['min'] = Math.floor(surviveSecond/60)
      surviveSecond = surviveSecond%60
      surviveTime['sec'] = Math.floor(surviveSecond)
      return surviveTime['hour'] + ':' + surviveTime['min'] + ':' + surviveTime['sec'];
    },
    og2TotalSurviveTime: function () {
      var surviveSecond = 0
      var surviveTime = {
        'hour': 0,
        'min': 0,
        'sec': 0
      }
      this.og2Time.forEach(function (e) {
        if((e['start_time'] != null) && (e['end_time'] != null)){
          var StartTimeArr = e['start_time'].split(":")
          StartTimeArr.forEach(function (ee, index) {   //convert String to Int
            StartTimeArr[index] = parseInt(ee)
          })
          var StartSec = StartTimeArr[0]*3600 + StartTimeArr[1]*60 + StartTimeArr[2]
          var EndTimeArr = e['end_time'].split(":")
          EndTimeArr.forEach(function (ee, index) {   //convert String to Int
            EndTimeArr[index] = parseInt(ee)
          })
          var EndSec = EndTimeArr[0]*3600 + EndTimeArr[1]*60 + EndTimeArr[2]
          surviveSecond += EndSec - StartSec
          console.log(surviveSecond)
        }
      })
      surviveTime['hour'] = Math.floor(surviveSecond/3600)
      surviveSecond = surviveSecond%3600
      surviveTime['min'] = Math.floor(surviveSecond/60)
      surviveSecond = surviveSecond%60
      surviveTime['sec'] = Math.floor(surviveSecond)
      return surviveTime['hour'] + ':' + surviveTime['min'] + ':' + surviveTime['sec'];
    }
  }
}
</script>

<style scoped>

</style>
