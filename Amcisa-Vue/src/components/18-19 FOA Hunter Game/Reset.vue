<template>
    <div>
      <el-button @click="reset('time')">Reset Time</el-button>
      <el-button @click="reset('cash')">Reset Cash</el-button>
      <el-button @click="reset('items')">Reset Items</el-button>
    </div>
</template>

<script>
import axios from 'axios'
export default {
  name: "Reset",
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
  }
}
</script>

<style scoped>

</style>
