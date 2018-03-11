<template>
  <div style="text-align: left; margin-left: 50px">
    <div v-if="this.$store.state.currentUser.isLoggedIn == true">
      <h2 style="margin-bottom: 80px">{{event.content.title}}</h2>
      <div v-for="field in event.content.fields">
        <component style="margin-top: 10px" :field="field" v-on:dataChanged="onDataUpdated" v-bind:is="field.type"></component>
      </div>
    </div>
    <el-button type="primary" style="margin-top: 80px; margin-bottom: 50px" v-if="event.content.isSubmit" @click="onSubmit">提交</el-button>
  </div>
</template>

<script>
import VueSelectImage from 'vue-select-image'
import axios from 'axios'
import FormValidFeedback from "bootstrap-vue/es/components/form/form-valid-feedback";
import Description from './fields/Description'
import TextInput from './fields/TextInput'
import TextArea from './fields/TextArea'
import Selections from './fields/Selections'
import ImageSelections from './fields/ImageSelections'
import UploadButton from './fields/UploadButton'
import SubmitButton from './fields/SubmitButton'

export default {
  name: 'Event',
  data () {
    return {
      vote: null,
      dataImages: [{
        id: '1',
        src: this.$store.state.baseUrl + '/api/download/1.jpg',
        alt: 'Alt Image 1'
      },
      {
        id: '2',
        src: this.$store.state.baseUrl + '/api/download/2.jpg',
        alt: 'Alt Image 2'
      },
      {
        id: '3',
        src: this.$store.state.baseUrl + '/api/download/3.jpg',
        alt: 'Alt Image 3'
      },
      {
        id: '4',
        src: this.$store.state.baseUrl + '/api/download/4.jpg',
        alt: 'Alt Image 4'
      },
      {
        id: '6',
        src: this.$store.state.baseUrl + '/api/download/6.jpg',
        alt: 'Alt Image 6'
      },
      {
        id: '7',
        src: this.$store.state.baseUrl + '/api/download/7.jpg',
        alt: 'Alt Image 7'
      },
      {
        id: '8',
        src: this.$store.state.baseUrl + '/api/download/8.jpg',
        alt: 'Alt Image 8'
      }],
      event: null,
      eventData: []
    }
  },
  components: {
    FormValidFeedback,
    VueSelectImage,
    Description,
    TextInput,
    TextArea,
    Selections,
    ImageSelections,
    UploadButton,
    SubmitButton
  },
  methods: {
    onDataUpdated(e){
      //this code is to update the appropriate this.eventData according to id of e, these code can be improved. Note that forEach not support break, return.
      console.log(e)
      var i = 0
      var isEqual = false
      this.eventData.forEach((f)=>{
        if(f.id == e.id){
          isEqual = true
        }
        else if(!isEqual){
          i++
        }
      })
      if(i<this.eventData.length){
        this.eventData[i] = e
      } else {
        this.eventData.push(e);
      }
    },
    onSubmit(){
      var files = []
      this.getAllFile(this.eventData, files)
      var formData = new FormData()
      var JsonEvent = JSON.stringify(this.eventData);
      files.forEach((file)=>{
        formData.append('file[]', file) //By convention, when appending multiple 'data[]' in formData, the backend can read this in array as 'data'. And get the array elements by data[0], data[1] ,...
      })
      formData.append('eventData', JsonEvent)

      axios.post('/api/eventData/post/' + this.event.id,
        formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data',
            'Authorization': 'Bearer ' + this.$store.state.currentUser.token
          }
        }
      ).then((response) => {
        console.log(response)
        this.$notify.success({
          title: '成功',
          message: '提交成功：'.concat(this.event.content.title)
        })
        this.$router.push({ name: 'Home' })
      }).catch((error) => {
        console.log(error.response)
        this.$notify.error({
          title: '错误',
          message: '提交失败：'.concat(this.event.content.title)
        })
      })
    },
    getAllFile(object, array){
      if(object == null || object == '') return
      if(object.isArray){
      } else if (typeof object == 'object') {
        if(object.hasOwnProperty('file') && object.file !=null && object.file != '')
        {
          array.push(object.file)
          console.log('pushed file!! ' + object.file)
        }
        console.log(typeof object)

        var allValues = Object.values(object)
        allValues.forEach((v)=>{
          this.getAllFile(v, array)
        })
      }
    }
  },
  created () {
    axios.defaults.baseURL = this.$store.state.baseUrl
    var axiosEvent = axios.create({
      headers: {'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
    })
    axiosEvent.get('/api/event/get/' + this.$route.query.id)
      .then(response => {
        this.event = response.data.event
      }).catch(error => {
        console.log(error)
      })

  }
}
</script>
