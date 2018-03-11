import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Event from '@/components/Event'
import AddEvent from '@/components/AddEvent'
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
      path: '/AddEvent',
      name: 'AddEvent',
      component: AddEvent
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
