import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Event from '@/components/Event'
import AddInfo from '@/components/AddInfo'
import Info from '@/components/Info'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/Event',
      name: 'Event',
      component: Event
    },
    {
      path: '/AddInfo',
      name: 'AddInfo',
      component: AddInfo
    },
    {
      path: '/Info',
      name: 'Info',
      component: Info
    }
  ]
})
