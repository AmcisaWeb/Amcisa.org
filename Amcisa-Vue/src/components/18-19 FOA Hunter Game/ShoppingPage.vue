<template>
  <div>
    <el-switch
      style="display: block"
      v-model="ogBol"
      active-color="#4f92ff"
      inactive-color="#57cc5f"
      active-text="OG2"
      inactive-text="OG1">
    </el-switch>
    <h3>可用时间：{{cash[og-1]}}秒</h3>
    <el-row style="padding-bottom: 50px">
      <el-col :span="8" v-for="(item, index) in items" offset="0">
        <el-card style="margin: 20px">
          <img :src="require('../../../src/assets/images/18-19_FOA_Hunter_Game/'+item.fileName)" width="200px">
          <h5>Price: {{item.price}} seconds</h5>
          <el-input-number v-model="item.qty" :min="0" :max="10"></el-input-number>
        </el-card>
      </el-col>
    </el-row>
    <el-row>
      <div style="background-color: #555555; position: fixed; bottom: 0px; z-index: 1; height: 50px; width: 100%; box-shadow: 0 0 20px grey">
        <el-col :span="20">
          <h3 style="color: ghostwhite; text-align: left; margin-left: 30px; padding-top: 10px; padding-bottom: 0px">Total price: {{totalPrice}}</h3>
        </el-col>
        <el-col :span="4">
          <el-button @click="checkOut()" style="height: 50px; width: 100%; background-color: aquamarine; padding-top: 10px">
              <h3>Check Out</h3>
          </el-button>
        </el-col>
      </div>
    </el-row>
  </div>
</template>

<script>
import axios from 'axios'
import Pusher from 'pusher-js'

export default {
  name: "ShoppingPage",
  data(){
    return{
      ogBol: false,
      cash: [0,0],
      items: [
        {
          name: 'First Aid Pack',
          price: 100,
          fileName: 'First Aid Pack.png',
          description: 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
          qty: 0
        },
        {
          name: 'Helmet',
          price: 500,
          fileName: 'Helmet.png',
          description: 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
          qty: 0
        },
        {
          name: 'Bag',
          price: 300,
          fileName: 'Bag.png',
          description: 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
          qty: 0
        },
        {
          name: 'Frying Pan',
          price: 50,
          fileName: 'Frying Pan.png',
          description: 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
          qty: 0
        },
        {
          name: 'M416',
          price: 800,
          fileName: 'M416.png',
          description: 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
          qty: 0
        },
      ]
    }
  },
  created () {
    axios.defaults.baseURL = this.$store.state.baseUrl
    this.updateCash()
    this.subscribe()
  },
  computed: {
    totalPrice: function () {
      var total = 0
      this.items.forEach(e => {
        total += e.qty * e.price
      })
      return total
    },
    og: function () {
      if (!this.ogBol) return 1
      else if (this.ogBol) return 2
    }
  },
  methods: {
    checkOut() {
      if(this.totalPrice>this.cash[this.og-1]){
        alert("秒数不足购买")
        return;
      }

      var axiosPurchase = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosPurchase.post('/api/18-19 FOA Hunter Game/Purchase', {
        og: this.og,
        item1: this.items[0].qty,
        item2: this.items[1].qty,
        item3: this.items[2].qty,
        item4: this.items[3].qty,
        item5: this.items[4].qty
      }).then(response => {
        this.$notify.success({
          title: '成功购买',
          message: response.data,
          duration: 1000
        })
      }).catch(error => {
        console.log(error)
      })
      this.items.forEach(e => {
        e.qty = 0
      })
    },
    updateCash(){
      var axiosInventory = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosInventory.get('/api/18-19 FOA Hunter Game/GetInventory')
        .then((response) => {
          this.cash[0] = response.data[0]['cash']
          this.cash[1] = response.data[1]['cash']
          this.$forceUpdate();
        })
        .catch((error) => {
          console.log(error)
        })
    },
    subscribe () {
      let pusher = new Pusher('e7fde66ab88312b757c3', { cluster: 'ap1' })
      pusher.subscribe('18-19_FOA_Hunter_Game')
      pusher.bind('PlayerEnded', data => {
        this.updateCash()
      })
      pusher.bind('Purchased', data => {
        this.updateCash()
      })
    }
  }
}
</script>

<style scoped>

</style>
