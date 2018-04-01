<template>
  <div>
    <h6 style="margin-bottom: 80px; white-space: pre-line">{{page.description}}</h6>
    <div v-for="f in page.fields">
      <component style="margin-top: 10px" :currentEventId="currentEventId" :field="f" v-on:dataChanged="onDataUpdated" v-bind:is="f.type"></component>
    </div>
    <el-button type="primary" style="margin-top: 80px; margin-bottom: 50px" v-if="page.isSubmit" @click="onSubmit">提交</el-button>
  </div>
</template>

<script>
  import axios from 'axios'
  import Description from './fields/Description'
  import TextInput from './fields/TextInput'
  import TextArea from './fields/TextArea'
  import Selections from './fields/Selections'
  import ImageSelections from './fields/ImageSelections'
  import UploadButton from './fields/UploadButton'
  import SubmitButton from './fields/SubmitButton'
  import ShowResponse from './fields/ShowResponse'
  import Picture from './fields/Picture'

  export default {
    name: 'Page',
    props:['page','currentEventId'],
    data () {
      return {
        response: []
      }
    },
    components: {
      Description,
      TextInput,
      TextArea,
      Selections,
      ImageSelections,
      UploadButton,
      SubmitButton,
      ShowResponse,
      Picture
    },
    methods: {
      onDataUpdated(e){
        //this code is to update the appropriate this.eventData according to id of e, these code can be improved. Note that forEach not support break, return.
        console.log(e)
        var i = 0
        var isEqual = false
        this.response.forEach((f)=>{
          if(f.id == e.id){
            isEqual = true
          }
          else if(!isEqual){
            i++
          }
        })
        if(i<this.response.length){
          this.response[i] = e
        } else {
          this.response.push(e);
        }
      },
      onSubmit(){
        var files = []
        this.getAllFile(this.response, files)
        var formData = new FormData()
        var JsonEvent = JSON.stringify(this.response);
        files.forEach((file)=>{
          formData.append('file[]', file) //By convention, when appending multiple 'data[]' in formData, the backend can read this in array as 'data'. And get the array elements by data[0], data[1] ,...
        })
        formData.append('eventData', JsonEvent)

        axios.post('/api/eventData/post/' + this.currentEventId + '/' + this.page.id,
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
            message: '提交成功：'.concat(this.page.title)
          })
          this.$router.push({ name: 'Home' })
        }).catch((error) => {
          console.log(error.response)
          var msg = '提交失败：'.concat(this.page.title)
          if(error.response.status == 421){
              msg= '提交失败：你已经提交过了。'
            this.$router.push({ name: 'Home' })
          }
          this.$notify.error({
            title: '错误',
            message: msg
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
    }
  }
</script>
