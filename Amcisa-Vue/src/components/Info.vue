<template>
  <div>
    <div v-if="loadCompleted">
      <div v-for="category in info" style="font-size: large;">
        <el-card class="box-card" style="margin: 50px">
          <el-collapse style="text-align: left">
          <h4>{{category[0].category}}</h4>
          <div v-for="item in category">
            <el-collapse-item :title="item.title" >
              <pre style="margin-bottom: -10px">{{item.description}}</pre>
            </el-collapse-item>
          </div>
        </el-collapse>
        </el-card>
      </div>
    </div>
    <router-link to="/" style="align-self: left">
      <el-button style="width: 300px; margin-bottom: 10px">返回主页</el-button>
    </router-link>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Events',
  data () {
    return {
      info: [],
      loadCompleted: false
    }
  },
  methods: {

  },
  async created () {
    axios.defaults.baseURL = this.$store.state.baseUrl
    var axiosInfo = axios.create({
      headers: {'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
    })
    await axiosInfo.get('/api/info/get')
      .then((response) => {
        var res = response.data.info
        res.forEach((e)=>{
          var i = 0;
          for(i;i<this.info.length;i++){
            if(this.info[i][0].category == e.content.category) {
              this.info[i].push(e.content);
              break;
            }
          }
          if(i>=this.info.length){  //if not assigned in the for loop
            this.info[i] = [];
            this.info[i].push(e.content);
          }
        })
      }).catch((error) => {
        console.log(error)
      })
      this.loadCompleted = true
  }
}
</script>
