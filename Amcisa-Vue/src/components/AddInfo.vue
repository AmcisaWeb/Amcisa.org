<template>
  <div style="width: 600px; margin-left: auto; margin-right: auto">
    <h5>Add Info Here</h5>
    <el-input placeholder="Category" v-model="info.catagory"></el-input>
    <el-input placeholder="Title" v-model="info.title"></el-input>
    <el-input
      type="textarea"
      :rows="2"
      placeholder="Description"
      v-model="info.description">
    </el-input>
    <el-button @click="addInfo()">ADD INFO</el-button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'AddEvent',
  data () {
    return {
      info: {
        catagory: '',
        title: '',
        description: ''
      }
    }
  },
  methods: {
    addInfo () {
      var axiosAddInfo = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosAddInfo.post('/api/info/post', {
        info: this.info
      }).then(response => {
        alert('successfully created events')
      }).catch(error => {
        alert('Add Info Error')
        console.log(error)
      })
    }
  },
  created () {
    axios.defaults.baseURL = this.$store.state.baseUrl
  }
}
</script>
