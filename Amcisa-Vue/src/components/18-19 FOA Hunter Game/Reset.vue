<template>
    <div>
      <div style="margin-top: 100px">
        <el-button @click="reset('time')">Reset Time</el-button>
        <el-button @click="reset('cash')">Reset Cash</el-button>
        <el-button @click="reset('items')">Reset Items</el-button>
      </div>

      <div style="margin-top: 100px">
        <el-switch
          style="display: block"
          v-model="ogBol"
          active-color="#4f92ff"
          inactive-color="#57cc5f"
          active-text="OG2"
          inactive-text="OG1">
        </el-switch>
        <el-input placeholder="Add Time in Seconds" v-model="inputCash" style="width: 200px"></el-input>
        <el-button @click="addCash">Add Time</el-button>
      </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
  name: "Reset",
  data () {
    return {
      inputCash: '',
      ogBol: false
    }
  },
  methods: {
    reset(e){
      var axiosReset = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      var url
      switch (e){
        case 'time':
          url = '/api/18-19 FOA Hunter Game/ResetTime'
          break
        case 'cash':
          url = '/api/18-19 FOA Hunter Game/ResetCash'
          break
        case 'items':
          url = '/api/18-19 FOA Hunter Game/ResetItems'
          break
      }
      axiosReset.post(url).then(response => {
        this.$notify.success({
          title: '成功',
          message: response.data,
          duration: 1000
        })
      }).catch(error => {
        console.log(error)
      })
    },
    addCash(){
      var axiosAddCash = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosAddCash.post('/api/18-19 FOA Hunter Game/AddCash', {
        og: this.og,
        cash: parseInt(this.inputCash)
      }).then(response => {
        this.$notify.success({
          title: '成功',
          message: response.data,
          duration: 1000
        })
      }).catch(error => {
        console.log(error)
      })
    }
  },
  computed: {
    og: function () {
      if (!this.ogBol) return 1
      else if (this.ogBol) return 2
    }
  }
}
</script>

<style scoped>

</style>
