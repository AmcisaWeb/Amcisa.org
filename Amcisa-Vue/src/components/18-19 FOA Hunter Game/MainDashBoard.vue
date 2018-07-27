<template>
  <div>
    <table style="width: 100%">
      <tr>
        <th><h3>OG</h3></th>
        <th><h3>Time</h3></th>
        <th><h3>Survive People</h3></th>
        <th v-for="img in itemImages">
          <img :src="require('../../../src/assets/images/18-19_FOA_Hunter_Game/'+img)"
            style="height: 100px">
        </th>
      </tr>
      <tr v-for="(r, index) in row">
        <td><h5>{{index+1}}</h5></td>
        <td><h5>{{r.cash}}</h5></td>
        <td><h5>{{r.survive}}</h5></td>
        <td v-for="i in r.item"><h5>{{i}}</h5></td>
      </tr>
    </table>
  </div>
</template>

<script>
import axios from 'axios'
import Pusher from 'pusher-js'

export default {
  name: 'MainDashBoard',
  data() {
      return {
        itemImages: [
          'First Aid Pack.png',
          'Helmet.png',
          'Bag.png',
          'Frying Pan.png',
          'M416.png'
        ],
        row: [{
          cash: 0,
          survive: 0,
          item:[]
        }, {
          cash: 0,
          survive: 0,
          item: []
        }]
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
          this.row[0].survive = 0
          this.row[1].survive = 0
          og1Time.forEach((e) => {
            if(e.end_time == null)
              this.row[0].survive ++
          })
          og2Time.forEach((e) => {
            if(e.end_time == null)
              this.row[1].survive ++
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
          this.row[0].cash = response.data[0]['cash']
          this.row[1].cash = response.data[1]['cash']

          this.row[0].item[0] = response.data[0]['item1']
          this.row[0].item[1] = response.data[0]['item2']
          this.row[0].item[2] = response.data[0]['item3']
          this.row[0].item[3] = response.data[0]['item4']
          this.row[0].item[4] = response.data[0]['item5']

          this.row[1].item[0] = response.data[1]['item1']
          this.row[1].item[1] = response.data[1]['item2']
          this.row[1].item[2] = response.data[1]['item3']
          this.row[1].item[3] = response.data[1]['item4']
          this.row[1].item[4] = response.data[1]['item5']

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
      })
      pusher.bind('PlayerEnded', data => {
        this.updateTime()
        this.updateInventory()
      })
      pusher.bind('Purchased', data => {
        this.updateInventory()
      })
    }
  }
}
</script>

<style scoped>
  th{
    border: 20px solid lightgray;
    background-color: #8cc5ff;
    border-radius: 75px;
    width: 100px;
  }
</style>
