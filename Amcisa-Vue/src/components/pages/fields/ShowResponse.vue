<template>
  <div v-loading="!loadCompleted">
    <div class="title">
      <h5 v-if="field.title!=''">{{field.title}}</h5>
    </div>
    <div v-if="loadCompleted == true">
      <div v-if="field.responseField.type == 'ImageSelections'">
        <div v-for="(res,index) in selectionReponse" style="margin-bottom: 50px">
          <img style="max-width: 300px" :src="$store.state.baseUrl + '/api/download/' + index">
          <br>票数：({{res}} / {{totalResult}})
        </div>
      </div>
      <div v-else-if="field.responseField.type == 'MultipleSelections'">
        <div v-for="(res,index) in selectionReponse" style="margin-bottom: 50px">
          {{index}}
          <br>票数：({{res}} / {{totalResult}})
          <el-progress style="max-width: 100px;"  :percentage="parseInt(res*100/totalResult)"></el-progress>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import VueSelectImage from 'vue-select-image'
  import axios from 'axios'

  export default {
    name: 'ShowResponse',
    props:['field','currentEventId'],
    data () {
      return {
        totalResult: 0,
        selectionReponse: {},
        loadCompleted: false
      }
    },
    async created(){
      axios.defaults.baseURL = this.$store.state.baseUrl
      if(this.field.responseField.type == 'ImageSelections'){
        var axiosEvent = axios.create({
          headers: {'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
        })
        axiosEvent.get('/api/eventData/get/' + this.currentEventId + '?fieldId=' + this.field.responseField.id)
          .then((response) => {
            console.log('/api/eventData/get/' + this.currentEventId + '?fieldId=' + this.field.responseField.id)
            this.selectionReponse = response.data
            Object.keys(this.selectionReponse).forEach((s) => {
              this.totalResult += this.selectionReponse[s]
            });
          }).catch((error) => {
          console.log(error)
        })
        this.loadCompleted = true
      }else if(this.field.responseField.type == 'MultipleSelections'){    //this is temporary solution
        for(var id of this.field.responseField.id) {
          var axiosEvent = axios.create({
            headers: {'Content-Type': 'application/json',
              'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
          })
          await axiosEvent.get('/api/eventData/get/' + this.currentEventId + '?fieldId=' + id)
            .then((response) => {
              console.log('/api/eventData/get/' + this.currentEventId + '?fieldId=' + id)
              for(var key in response.data){
                if(this.selectionReponse.hasOwnProperty(key))
                  this.selectionReponse[key] += response.data[key]
                else{
                  this.selectionReponse[key] = response.data[key]
                }

              }
            }).catch((error) => {
              console.log(error)
            })
        }
        Object.keys(this.selectionReponse).forEach((s) => {
          this.totalResult += this.selectionReponse[s]
        });
        this.loadCompleted = true

      }
    }
  }
</script>
