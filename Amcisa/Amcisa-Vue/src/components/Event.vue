<template>
  <div>
    <div v-if="this.$store.state.currentUser.isLoggedIn == true">
      <h4>请选择你爱的设计, 然后按“投票”. 一人只有一票~</h4>
      <vue-select-image :dataImages="dataImages"
                        @onselectimage="onSelectImage"
                        style="margin: 10%; margin-bottom: 0; margin-top: 5%">
      </vue-select-image>
      <el-button @click="handleClick()" style="margin: 5%">投票</el-button>
    </div>
    <div v-else>请返回主页登录</div>
  </div>
</template>

<script>
import VueSelectImage from 'vue-select-image'
import axios from 'axios'

export default {
  name: 'Event',
  data () {
    return {
      vote: null,
      dataImages: [{
        id: '1',
        src: this.$store.state.baseUrl + '/api/download/1.jpg',
        alt: 'Alt Image 1'
      },
      {
        id: '2',
        src: this.$store.state.baseUrl + '/api/download/2.jpg',
        alt: 'Alt Image 2'
      },
      {
        id: '3',
        src: this.$store.state.baseUrl + '/api/download/3.jpg',
        alt: 'Alt Image 3'
      },
      {
        id: '4',
        src: this.$store.state.baseUrl + '/api/download/4.jpg',
        alt: 'Alt Image 4'
      },
      {
        id: '5',
        src: this.$store.state.baseUrl + '/api/download/5.jpg',
        alt: 'Alt Image 5'
      },
      {
        id: '6',
        src: this.$store.state.baseUrl + '/api/download/6.jpg',
        alt: 'Alt Image 6'
      },
      {
        id: '7',
        src: this.$store.state.baseUrl + '/api/download/7.jpg',
        alt: 'Alt Image 7'
      },
      {
        id: '8',
        src: this.$store.state.baseUrl + '/api/download/8.jpg',
        alt: 'Alt Image 8'
      }]
    }
  },
  components: { VueSelectImage },
  methods: {
    onSelectImage (selected) {
      this.vote = selected.id
    },
    handleClick () {
      if (this.vote == null){
        alert('请选择一种设计, 不要投废票Plsss~')
      } else {
        var axiosAmtee = axios.create({
          headers: {'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
        })
        axiosAmtee.post('/api/amtee', {
          vote: this.vote
        }).then(response => {
          alert('成功投票')
          this.$router.push('/')
        }).catch(error => {
          if(error.response.status == 404){
            alert('您已经投过票了')
            this.$router.push('/')
          } else {
            alert('Server Error')
            console.log(error)
          }
        })
      }
    }
  },
  created () {
    axios.defaults.baseURL = this.$store.state.baseUrl
  }
}
</script>
