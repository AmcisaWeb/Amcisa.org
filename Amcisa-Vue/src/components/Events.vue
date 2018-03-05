<template>
  <div>
    <div v-for="e in events" style="max-width: 300px; margin-left: auto; margin-right: auto; margin-top: 50px">
      <el-card :body-style="{ padding: '0px' }">
        <el-button type="text" class="button" @click="handleClick()">
          <img src="http://localhost/api/download/15184543725198.jpeg" class="image">
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
    handleClick() {
      this.$router.push('Event')
    }
  },
  watch: {
    isLogin: function () {
      axios.defaults.baseURL = this.$store.state.baseUrl
      var axiosEvent = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosEvent.get('/api/event/get/*')
        .then(response => {
          this.events = response.data.events
          console.log(this.events)
        }).catch(error => {
          console.log(error)
        })
    }
  },
  computed: {
    isLogin () {
      return this.$store.state.currentUser.isLoggedIn
    }
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
