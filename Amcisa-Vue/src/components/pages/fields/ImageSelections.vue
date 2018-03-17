<template>
  <div>
    <div class="title">
      <h5 v-show="field.title!=''">{{field.title}}</h5>
    </div>
    <div v-if="showResult">
      目前票数:
      <div v-for="(res,index) in selectionResult" style="margin-bottom: 20px">
        <img style="max-width: 500px" :src="$store.state.baseUrl + '/api/download/' + index">
        <el-progress style="max-width: 100px" :text-inside="true" :stroke-width="18" :percentage="res*100/totalResult"></el-progress>
      </div>
    </div>
    <vue-select-image :dataImages="dataImage"
                      @onselectimage="onSelectImage"
                      style="margin: 10%; margin-bottom: 0; margin-top: 5%">
    </vue-select-image>

  </div>
</template>

<script>
import VueSelectImage from 'vue-select-image'
import axios from 'axios'

export default {
  name: 'ImageSelections',
  props:['field','currentEventId'],
  data () {
    return {
      eventData:{
        id: this.field.id,
        content: ''
      },
      dataImage: [],
      showResult: false,
      selectionResult: [],
      totalResult: 0
    }
  },
  components: { VueSelectImage },
  methods:{
    onSelectImage(selected){
      var len = (this.$store.state.baseUrl + '/api/download/').length
      this.eventData.content = selected.src.substring(len)
    }
  },
  watch: {
    eventData: {
      handler: function (newData, oldData) {
        this.$emit('dataChanged',this.eventData)
      },
      deep:true
    }
  },
  created(){
    axios.defaults.baseURL = this.$store.state.baseUrl
    var i = 0;
    this.field.selections.forEach((e)=>{
      i++
      this.dataImage.push({id: i,src: this.$store.state.baseUrl + '/api/download' + e.filename})
    })
    this.showResult = this.field.showResult
    if(this.showResult == true){

      var axiosEvent = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosEvent.get('/api/eventData/get/' + this.currentEventId + '?fieldId=' + this.field.id)
      .then((response) => {
        this.selectionResult = response.data
        Object.keys(this.selectionResult).forEach((s) => {
          this.totalResult += this.selectionResult[s]
        });
      }).catch((error) => {
        console.log(error)
      })
    }
  }
}
</script>
