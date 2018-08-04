<template>
  <div :style="backgroundColor">
    <div style="margin-top: 50px">
      <span style="font-size: 5vw; color: lightgrey">{{hr}}:{{min}}:{{sec}}</span>
    </div>
    <div style="margin-top: 10px;">
      <el-input-number v-model="hr" :min="0" :max="23"></el-input-number>
      <el-input-number v-model="min" :min="0" :max="59"></el-input-number>
      <el-input-number v-model="sec" :min="0" :max="59"></el-input-number>
    </div>

    <el-switch
      style="display: block; margin-top: 50px; margin-bottom: 30px;"
      v-model="ogBol"
      active-color="#e81212"
      inactive-color="#3884ff"
    >
    </el-switch>
    <el-button @click="End">{{ogName}} End</el-button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'PlayerEnd',
  data () {
    return {
      hr:0,
      min:0,
      sec:0,
      ogBol: false
    }
  },
  methods: {
    End () {
      var axiosPlayerEnd = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosPlayerEnd.post('/api/18-19 FOA Hunter Game/PlayerEnd', {
        og: this.og,
        end_time: this.hr + ':' + this.min + ':' + this.sec
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
  },
  computed: {
    backgroundColor: function() {
      if (!this.ogBol) return {
        'background-color': 'darkblue'
      }
      else if (this.ogBol) return {
        'background-color': 'darkred'
      }
    },
    og: function () {
      if (!this.ogBol) return 1
      else if (this.ogBol) return 2
    },
    ogName: function () {
      if (!this.ogBol) return '云雨'
      else if (this.ogBol) return '虹晴'
    },
  }
}
</script>

<style scoped>

</style>
