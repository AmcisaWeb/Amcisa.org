<template>
  <div class="login-form">
    <div v-if="this.$store.state.currentUser.isLoggedIn == false">
      <el-input placeholder="School Email" v-model="email" style="width: 300px; margin-bottom: 10px"></el-input>
      <br>
      <el-input placeholder="Password"  v-model="password" style="width: 300px; margin-bottom: 10px" type="password"></el-input>
      <br>
      <el-button  type="primary" @click="handleLogin()" style="width: 300px">LOGIN</el-button>
      <br>
      <a :href="this.$store.state.baseUrl + '/password/reset'">Reset Password</a>
    </div>
    <div v-else>
      <h5>Hi! {{this.$store.state.currentUser.name_ch}}</h5>
      <el-button type="primary" @click="handleLogout()">LOGOUT</el-button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'App',
  data () {
    return {
      email: null,
      password: null
    }
  },
  methods: {
    handleLogin () {
      var axiosToken = axios.create({
        headers: {'Content-Type': 'application/json'}
      })
      axiosToken.post('/oauth/token', {
        grant_type: 'password',
        client_id: 1,
        client_secret: '656qdZkintJzWSBKaaipFnRQzmP2SVrmdTPafbU5',
        username: this.email,
        password: this.password
      }).then(response => {
        this.$store.commit('setToken', response.data.access_token)
      }).catch(error => {
        alert('Password Error')
        this.$store.commit('setToken', null)
        console.log(error)
      })
    },
    handleLogout () {
      this.$store.commit('setToken', null)
    }
  },
  created () {
    axios.defaults.baseURL = this.$store.state.baseUrl
  }
}
</script>

<style scoped>
  /* this file is download from https://bttn.surge.sh/ */
  @import "../assets/css/bttn.min.css";

  .drop-down {
    position: relative;
    background: white;
    -webkit-box-shadow: inset 0 7px 9px -7px rgba(0,0,0,100),inset 0 -7px 9px -7px rgba(0,0,0,100);
    box-shadow: inset 0 7px 9px -7px rgba(0,0,0,100),inset 0 -7px 9px -7px rgba(0,0,0,100);
  }

</style>
