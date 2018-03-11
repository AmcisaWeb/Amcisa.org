<template>
  <div>
    <div v-for="e in events" style="max-width: 300px; margin-left: auto; margin-right: auto; margin-top: 50px; margin-bottom: 50px">
      <el-card :body-style="{ padding: '0px' }">
        <el-button type="text" class="button" @click="handleClick(e.id)">
          <img :src="$store.state.baseUrl + '/api/download'+ e.content.thumbnail.filename" class="image">
          <div style="padding: 14px;">
            <h3>{{e.content.title}}</h3>
            <div class="bottom clearfix">
              <time class="time">{{e.content.description}}</time>
            </div>
          </div>
        </el-button>
      </el-card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Events',
  data () {
    return {
      events: null
    }
  },
  methods: {
    handleClick(eventId) {
      this.$router.push({path: '/Event?id=' + eventId})
    },
    loadEvents(){
      var axiosEvent = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosEvent.get('/api/event/get/*')
        .then(response => {
          this.events = response.data.events
          console.log(response.data.events)
        }).catch(error => {
        console.log(error)
      })
    }
  },
  watch: {
    isLogin: function () {
      this.loadEvents()
    }
  },
  computed: {
    isLogin () {
      return this.$store.state.currentUser.isLoggedIn
    }
  },
  created(){
    axios.defaults.baseURL = this.$store.state.baseUrl
    this.loadEvents()
  }
}
</script>

<style scoped>
  .bottom {
    margin-top: 13px;
    line-height: 12px;
  }

  .button {
    padding: 0;
    float: right;
  }

  .image {
    width: 100%;
    display: block;
  }

  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }

  .clearfix:after {
    clear: both
  }
</style>
