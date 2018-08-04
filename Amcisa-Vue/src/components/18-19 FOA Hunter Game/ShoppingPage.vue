<template>
  <div>

    <el-switch
      style="display: block; margin-top: 50px; margin-bottom: 30px"
      v-model="ogBol"
      active-color="#e81212"
      inactive-color="#3884ff"
      >
    </el-switch>
    <span style="font-size: 8vw" :style="ogColor">{{ogName}}</span>
    <br>
    <span style="font-size: 2vw">可用时间：{{cash[og-1]}}秒</span>


    <el-row style="padding-bottom: 50px">
      <el-col :span="8" v-for="(item, index) in items" offset="0">
        <el-card style="margin: 20px">
          <img :src="require('../../../src/assets/18-19_FOA_Hunter_Game/images/'+item.fileName)" width="200px">
          <h6>{{item.description}}</h6>
          <h5>价格: {{item.price}} 秒</h5>
          <el-input-number v-model="item.qty" :min="0" :max="10"></el-input-number>
        </el-card>
      </el-col>
    </el-row>


    <el-row>
      <div style="background-color: #555555; position: fixed; bottom: 0px; z-index: 1; height: 50px; width: 100%; box-shadow: 0 0 20px grey">
        <el-col :span="20">
          <h3 style="color: ghostwhite; text-align: left; margin-left: 30px; padding-top: 10px; padding-bottom: 0px">价格: {{totalPrice}}秒</h3>
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
          name: 'Back Pack',
          price: 1800,
          fileName: 'Bag.png',
          description: '玩家可背着Back Pack吸引猎人的注意， 进而调虎离山帮助队友进行破解任务。两组同时拥有Back Pack的队伍出现在l猎人前，猎人将随机追击。',
          qty: 0
        },
        {
          name: 'Med Kit',
          price: 3600,
          fileName: 'First Aid Pack.png',
          description: '被猎人淘汰后，可选择到医疗所(任意的绳结板处)使用急救包，从而获得再次复活的机会，使用次数为一次。',
          qty: 0
        },
        {
          name: 'Frying Pan',
          price: 15000,
          fileName: 'Frying Pan.png',
          description: '玩家可使用平底锅对其中一位猎人作用，该猎人酱失去作用，使用次数为一次。',
          qty: 0
        }
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
    },
    ogName: function () {
      if (!this.ogBol) return '云雨'
      else if (this.ogBol) return '虹晴'
    },
    ogColor: function () {
      if (!this.ogBol) return {
        color: 'blue'
      }
      else if (this.ogBol) return {
        color: 'red'
      }
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
        back_pack: this.items[0].qty,
        med_kit: this.items[1].qty,
        frying_pan: this.items[2].qty
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
