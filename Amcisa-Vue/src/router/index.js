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
    },
    {
      path: '/18-19FOAHunterGame/PlayerStart',
      component: require('@/components/18-19 FOA Hunter Game/PlayerStart').default
    },
    {
      path: '/18-19FOAHunterGame/PlayerEnd',
      component: require('@/components/18-19 FOA Hunter Game/PlayerEnd').default
    },
    {
      path: '/18-19FOAHunterGame/MainDashBoard',
      component: require('@/components/18-19 FOA Hunter Game/MainDashBoard').default
    },
    {
      path: '/18-19FOAHunterGame/TimeDashBoard',
      component: require('@/components/18-19 FOA Hunter Game/TimeDashBoard').default
    },
    {
      path: '/18-19FOAHunterGame/ShoppingPage',
      component: require('@/components/18-19 FOA Hunter Game/ShoppingPage').default
    },
    {
      path: '/18-19FOAHunterGame/Reset',
      component: require('@/components/18-19 FOA Hunter Game/Reset').default
    }
  ]
})
