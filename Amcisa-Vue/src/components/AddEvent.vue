<template>
  <div>
    <el-dropdown @command="assignEvent">
      <el-button type="primary">
        Existing Events<i class="el-icon-arrow-down el-icon--right"></i>
      </el-button>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item v-for="e in existingEvents" :command="e">{{e.title}}</el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>

    <el-input placeholder="Event Title" v-model="events.title"></el-input>


    <button @click="events.page.push(template.page)">Add Tab</button>
    <el-tabs type="border-card">
      <el-tab-pane v-for="(p, pIndex) in events.page" :label="p.title">
        <el-input v-model="p.title"></el-input>
        <el-input placeholder="Event Description" v-model="p.description"></el-input>
        <h7>Is this form to be submit?</h7>
        <el-switch v-model="p.isSubmit">
        </el-switch>
        <br>
        <el-dropdown @command="(e)=>{p.role = e}">
          <span class="el-dropdown-link">
            <span v-if="p.role==''">Role available to see this event</span>
            <span v-else>{{p.role.charAt(0).toUpperCase() + p.role.slice(1)}}</span>
            <i class="el-icon-arrow-down el-icon--right"></i>
          </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item command="guest">Guest</el-dropdown-item>
            <el-dropdown-item command="member">Member</el-dropdown-item>
            <el-dropdown-item command="president">President</el-dropdown-item>
            <el-dropdown-item command="admin">Admin</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>

        <el-upload
          :limit="1"
          class="upload-demo"
          drag
          :auto-upload="false"
          action="https://jsonplaceholder.typicode.com/posts/"
          :on-change="onChanged"
          :on-remove="onRemoved">
          <i class="el-icon-upload"></i>
          <div class="el-upload__text">Upload the event thumbnail</div>
        </el-upload>
        <br>
        <div v-show="false">
          <description v-on:created="(e)=>{template.Description = e}"></description>
          <text-input v-on:created="(e)=>{template.TextInput = e}"></text-input>
          <text-area v-on:created="(e)=>{template.TextArea = e}"></text-area>
          <selections v-on:created="(e)=>{template.Selections = e}"></selections>
          <image-selections v-on:created="(e)=>{template.ImageSelections = e}"></image-selections>
          <upload-button v-on:created="(e)=>{template.UploadButton = e}"></upload-button>
          <submit-button v-on:created="(e)=>{template.SubmitButton = e}"></submit-button>
          <show-response v-on:created="(e)=>{template.ShowResponse = e}"></show-response>
        </div>
        <el-dropdown split-button type="primary" @click="onAdd" @command="(e)=>{selectedTemplate = e}">
          Add {{selectedTemplate.replace(/([A-Z])/g, ' $1').trim()}}
          <el-dropdown-menu slot="dropdown" ref="dropdown">
            <el-dropdown-item command="Description">Description</el-dropdown-item>
            <el-dropdown-item command="TextInput">Text Input</el-dropdown-item>
            <el-dropdown-item command="TextArea">Text Area</el-dropdown-item>
            <el-dropdown-item command="Selections">Selections</el-dropdown-item>
            <el-dropdown-item command="ImageSelections">Image Selections</el-dropdown-item>
            <el-dropdown-item command="UploadButton">Upload Button</el-dropdown-item>
            <el-dropdown-item command="SubmitButton">Submit Button</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
        <div v-for="field in p.fields">
          <component :id="field.id" v-on:dataChanged="onFieldUpdated" v-bind:is="field.type"></component>
        </div>


      </el-tab-pane>
    </el-tabs>

    <el-button @click="onSubmit" style="margin-top: 100px">Add Event</el-button>

  </div>
</template>

<script>
  import axios from 'axios'
  import VueUploadComponent from 'vue-upload-component'
  import VueSelectImage from 'vue-select-image'
  import draggable  from 'vuedraggable'
  import Description from './pages/fields-template/Description'
  import TextInput from './pages/fields-template/TextInput'
  import TextArea from './pages/fields-template/TextArea'
  import Selections from './pages/fields-template/Selections'
  import ImageSelections from './pages/fields-template/ImageSelections'
  import UploadButton from './pages/fields-template/UploadButton'
  import SubmitButton from './pages/fields-template/SubmitButton'
  import ShowResponse from './pages/fields-template/ShowResponse'


  export default {
    name: 'AddEvent',
    data () {
      return {
        selectedTemplate:'',
        sampleImageSelections: [{
          id: '1',
          src: 'http://placekitten.com/280/320',
          alt: 'Alt Image 1'
        }, {
          id: '2',
          src: 'http://placekitten.com/280/320',
          alt: 'Alt Image 2'
        }],
        sampleUploadFiles: [],
        events:{
          title:'',
          thumbnail:{
            file:'',
            filename:''
          },
          page:[],
        },
        existingEvents:[],
        template:{
          page:{
            title:'New Tab',
            role:'',
            description:'',
            isSubmit: true,
            fields:[]
          }
        }
      }
    },
    components: {
      'file-upload': VueUploadComponent,
      draggable,
      VueSelectImage,
      Description,
      TextInput,
      TextArea,
      Selections,
      ImageSelections,
      UploadButton,
      SubmitButton,
      ShowResponse
    },
    methods: {
      assignEvent(e){
        this.events = Object.assign({}, e);;
      },
      onFieldUpdated(e){
        //this code is to update the appropriate this.events.fields according to id of e, these code can be improved. Note that forEach not support break, return.
        var i = 0
        var isEqual = false
        this.events.page[0].fields.forEach((f)=>{
          if(f.id == e.field.id){
            isEqual = true
          }
          else if(!isEqual){
            i++
          }
        })
        if(i<this.events.page[0].fields.length){
          this.events.page[0].fields[i] = e.field
        }
        else console.log('Error in onFieldUpdated')
      },
      onAdd(){
        if(this.selectedTemplate=='' | this.selectedTemplate==null){
          this.$notify.error({
            title: 'Error',
            message: 'You did not select any things'
          });
        } else {
          const field = Object.assign({}, this.template[this.selectedTemplate].field)
          field.id = this.$uuid.v4()
          this.events.page[0].fields.push(field)
        }
      },
      onChanged(e){
        this.events.thumbnail.file = e.raw
      },
      onRemoved(){
        this.events.thumbnail.file = null;
      },
      onSubmit(){
        var files = []
        this.getAllFile(this.events, files)
        var formData = new FormData()
        var JsonEvent = JSON.stringify(this.events);
        files.forEach((file)=>{
          formData.append('file[]', file) //By convention, when appending multiple 'data[]' in formData, the backend can read this in array as 'data'. And get the array elements by data[0], data[1] ,...
        })
        formData.append('event', JsonEvent)
        axios.post('/api/event/post',
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data',
              'Authorization': 'Bearer ' + this.$store.state.currentUser.token
            }
          }
        ).then(function (response) {
          console.log(response)
        }).catch(function (error) {
          console.log(error.response)
        })
      },
      getAllFile(object, array){
        if(object == null || object == '') return
        if(object.isArray){
        } else if (typeof object == 'object') {
          if(object.hasOwnProperty('file') && object.file !=null && object.file != '')
          {
            array.push(object.file)
          }
          var allValues = Object.values(object)
          allValues.forEach((v)=>{
            this.getAllFile(v, array)
          })
        }
      }
    },
    created () {
      axios.defaults.baseURL = this.$store.state.baseUrl
      var axiosEvents = axios.create({
        headers: {'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + this.$store.state.currentUser.token }
      })
      axiosEvents.get('/api/event/get/*')
        .then(response => {
          this.existingEvents = response.data.events
          console.log('existing event: ')
          console.log(this.existingEvents)

        }).catch(error => {
          console.log(error.response)
        })
      this.events.page.push(this.template.page)
    }
  }
</script>
