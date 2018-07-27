<template>
  <div>
    <el-button @click="End(1)">OG1 End</el-button>
    <el-button @click="End(2)">OG2 End</el-button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'PlayerEnd',
  methods: {
    End (ogNumber) {
      var axiosPlayerStart = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosPlayerStart.post('/api/18-19 FOA Hunter Game/PlayerEnd', {
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
