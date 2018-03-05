<template>
  <div>
    <el-button @click="addEvent()"></el-button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'AddEvent',
  data () {
    return {
      event: {
        title: 'AmTee投票',
        thumbnail: '/path to thumbnail',
        description: '投选你最爱的AmTee设计！',
        fields: [
          { id: 1,
            type: 'selections_image',
            title: 'Please Select',
            isInput: true,
            selections: [{image: '/path to image 1', text: 'text of image 1'},
              {image: '/path to image 2', text: 'text of image 2'},
              {image: '/path to image 3', text: 'text of image 3'}
            ]},
          { type: 'submit' }
        ]
      }
    }
  },
  methods: {
    addEvent () {
      var axiosAddEvent = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosAddEvent.post('/api/event/post', {
        event: this.event
      }).then(response => {
        alert('successfully created events')
      }).catch(error => {
        alert('Create event error')
        console.log(this.event)
        console.log(error)
      })
    }
  },
  created () {
    axios.defaults.baseURL = this.$store.state.baseUrl
  }
}
</script>
