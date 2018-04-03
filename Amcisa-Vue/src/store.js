import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export const store = new Vuex.Store({
  state: {
    currentUser: {id: null,
      matric_no: null,
      email: null,
      name_en: null,
      name_ch: null,
      gender: null,
      course: null,
      birth_date: null,
      secondary_school: null,
      phone_sg: null,
      phone_my: null,
      university: null,
      token: null,
      isLoggedIn: false },
    baseUrl: 'http://amcisa.org'
  },
  mutations: {
    setToken (state, token) {
      if (token != null) {
        var axiosUser = axios.create({
          headers: {'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token }
        })
        axiosUser.get(state.baseUrl + '/api/user')
          .then(response => {
            localStorage.setItem('token', token)
            state.currentUser.token = token
            state.currentUser.isLoggedIn = true
            state.currentUser.matric_no = response.data.user.matric_no
            state.currentUser.email = response.data.user.email
            state.currentUser.name_en = response.data.user.name_en
            state.currentUser.name_ch = response.data.user.name_ch
            state.currentUser.gender = response.data.user.gender
            state.currentUser.course = response.data.user.course
            state.currentUser.birth_date = response.data.user.birth_date
            state.currentUser.secondary_school = response.data.user.secondary_school
            state.currentUser.phone_sg = response.data.user.phone_sg
            state.currentUser.phone_my = response.data.user.phone_my
            state.currentUser.university = response.data.user.university
          })
          .catch(error => {
            alert('Password Error')
            this.$store.commit('setToken', null)
            console.log(error)
          })
      } else {
        localStorage.removeItem('token')
        state.currentUser.matric_no = null
        state.currentUser.email = null
        state.currentUser.name_en = null
        state.currentUser.name_ch = null
        state.currentUser.gender = null
        state.currentUser.course = null
        state.currentUser.birth_date = null
        state.currentUser.secondary_school = null
        state.currentUser.phone_sg = null
        state.currentUser.phone_my = null
        state.currentUser.university = null
        state.currentUser.token = null
        state.currentUser.isLoggedIn = false
      }
    }
  }
})





























