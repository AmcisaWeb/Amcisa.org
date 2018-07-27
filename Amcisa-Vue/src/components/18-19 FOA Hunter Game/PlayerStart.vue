<template>
  <div>
    <el-button @click="Start(1)">OG1 Start</el-button>
    <el-button @click="Start(2)">OG2 Start</el-button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'PlayerStart',
  methods: {
    Start (ogNumber) {
      var axiosPlayerStart = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosPlayerStart.post('/api/18-19 FOA Hunter Game/PlayerStart', {
        og: ogNumber
      }).then(response => {
        this.$notify.success({
          title: '成功',
          message: response.data,
          duration: 1000
        })
      }).catch(error => {
        this.$notify.success({
          title: '成功',
          message: response.data,
          duration: 1000
        })
      })
    }
  }
}
</script>

<style scoped>

</style>
