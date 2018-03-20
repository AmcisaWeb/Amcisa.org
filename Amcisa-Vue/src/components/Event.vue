<template>
  <div style="text-align: left; margin-left: 5%; margin-right: 5%">
    <div>
      <el-tabs type="border-card" ref="tab" v-if="loadCompleted==true">
        <el-tab-pane v-for="(p,index) in event.page" :label="p.title" :name="index.toString()">
          <page :page="p" :currentEventId="event.id"></page>
        </el-tab-pane>
      </el-tabs>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  import Page from './pages/page'


  export default {
    name: 'Event',
    data () {
      return {
        event: null,
        loadCompleted: false
      }
    },
    components: {
      Page
    },
    methods:{

    },
    async created () {
      axios.defaults.baseURL = this.$store.state.baseUrl
      var axiosEvent = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      await axiosEvent.get('/api/event/get/' + this.$route.query.id)
        .then(response => {
          this.event = response.data.events
        }).catch(error => {
          console.log(error)
        })
      this.loadCompleted = true
    },
    computed:{

    }
  }
</script>

