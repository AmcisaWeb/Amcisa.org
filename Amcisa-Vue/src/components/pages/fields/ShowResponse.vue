<template>
  <div>
    <div class="title">
      <h5 v-show="field.title!=''">{{field.title}}</h5>
    </div>
    <div v-if="field.responseField.type == 'ImageSelections'">
      <div v-for="(res,index) in selectionReponse" style="margin-bottom: 50px">
          <img style="max-width: 300px" :src="$store.state.baseUrl + '/api/download/' + index">
          <el-progress style="max-width: 100px; margin-top: -20px" :text-inside="true" :stroke-width="18" :percentage="parseInt(res*100/totalResult)"></el-progress>
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
        selectionReponse: []
      }
    },
    created(){
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
      }
    }
  }
</script>
