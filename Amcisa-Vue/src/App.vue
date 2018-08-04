<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
import NavBar from './components/NavBar'
import LoginForm from './components/LoginForm'
import Events from './components/Events'
import AddEvent from './components/AddEvent'
import backup from './components/backup'
import axios from 'axios'

export default {
  name: 'App',
  components: {
    'nav-bar': NavBar,
    'login-form': LoginForm,
    'events': Events,
    'add-event': AddEvent,
    'backup': backup
  },
  created () {
    axios.defaults.baseURL = this.$store.state.baseUrl
    var token = localStorage.getItem('token')
    if (token != null) {
      this.$store.commit('setToken', token)
    }
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
