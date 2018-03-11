<template>
  <div>
    <el-input placeholder="Event Title" v-model="events.title"></el-input>
    <el-input placeholder="Event Description" v-model="events.description"></el-input>
    <h7>Is this form to be submit?</h7>
    <el-switch v-model="events.isSubmit">
    </el-switch>
    <br>
    <h7>Page of event:</h7>
    <el-input-number v-model="events.page" :min="1" :max="10"></el-input-number>
    <br>

    <el-dropdown @command="(e)=>{this.events.role = e}">
    <span class="el-dropdown-link">
      <span v-if="this.events.role==''">Role available to see this event</span>
      <span v-else>{{this.events.role.charAt(0).toUpperCase() + this.events.role.slice(1)}}</span>
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
    </div>
    <div class="example">
      <div v-show="selected == 'Description'">
        <p>Description here...</p>
      </div>
      <div v-show="selected == 'TextInput'" >
        <span>Input Box: </span><el-input style="max-width: 300px; margin-left: auto; margin-right: auto" placeholder="Please input"></el-input>
      </div>
      <div v-show="selected == 'TextArea'" >
        <span>Text Area: </span>
        <el-input
          style="max-width: 300px; margin-left: auto; margin-right: auto"
          type="textarea"
          :rows="2"
          placeholder="Please input">
        </el-input>
      </div>
      <div v-show="selected == 'Selections'">
        <span>Selections: </span>
        <el-select placeholder="Select">
          <el-option>Selections 1</el-option>
          <el-option>Selections 2</el-option>
          <el-option>Selections 3</el-option>
          <el-option>Selections 4</el-option>
          <el-option>Selections 5</el-option>
        </el-select>
      </div>
      <div v-show="selected == 'ImageSelections'" style="max-width: 300px; margin-left: auto; margin-right: auto; text-align: left">
        <span>Image Selections: </span>
        <vue-select-image
          :dataImages="sampleImageSelections"
          h="130px"
          w="100px"></vue-select-image>
      </div>
      <div v-show="selected == 'UploadButton'" style="max-width: 500px; margin-left: auto; margin-right: auto; text-align: left">
        <el-upload
          class="upload-demo"
          drag
          action="https://jsonplaceholder.typicode.com/posts/"
          :auto-upload="false"
          multiple>
          <i class="el-icon-upload"></i>
          <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
          <div class="el-upload__tip" slot="tip">jpg/png files with a size less than 500kb</div>
        </el-upload>
      </div>
      <div v-show="selected == 'SubmitButton'" style="max-width: 500px; margin-left: auto; margin-right: auto; text-align: left">
        <el-button type="primary">Submit</el-button>
      </div>
    </div>
    <el-dropdown split-button type="primary" @click="onAdd" @command="(e)=>{this.selected = e}">
      Add {{selected.replace(/([A-Z])/g, ' $1').trim()}}
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
    <div v-for="field in  events.fields">
      <component :id="field.id" v-on:dataChanged="onFieldUpdated" v-bind:is="field.type"></component>
    </div>
    <el-button @click="onSubmit" style="margin-top: 100px">Add Event</el-button>

  </div>
</template>

<script>
  import axios from 'axios'
  import VueUploadComponent from 'vue-upload-component'
  import VueSelectImage from 'vue-select-image'
  import draggable  from 'vuedraggable'
  import Description from './fields-template/Description'
  import TextInput from './fields-template/TextInput'
  import TextArea from './fields-template/TextArea'
  import Selections from './fields-template/Selections'
  import ImageSelections from './fields-template/ImageSelections'
  import UploadButton from './fields-template/UploadButton'
  import SubmitButton from './fields-template/SubmitButton'


  export default {
    name: 'AddEvent',
    data () {
      return {
        parent:'asdadads',
        selected:'',
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
          role:'',
          description:'',
          isSubmit: true,
          page:'',
          fields:[]
        },
        template:{}
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
      SubmitButton
    },
    methods: {
      onFieldUpdated(e){
        //this code is to update the appropriate this.events.fields according to id of e, these code can be improved. Note that forEach not support break, return.
        var i = 0
        var isEqual = false
        this.events.fields.forEach((f)=>{
          if(f.id == e.field.id){
            isEqual = true
          }
          else if(!isEqual){
            i++
          }
        })
        if(i<this.events.fields.length){
          this.events.fields[i] = e.field
        }
        else console.log('Error in onFieldUpdated')
      },
      onAdd(){
        if(this.selected=='' | this.selected==null){
          this.$notify.error({
            title: 'Error',
            message: 'You did not select any things'
          });
        } else {
          const field = Object.assign({}, this.template[this.selected].field)
          field.id = this.$uuid.v4()
          this.events.fields.push(field)
        }
      },
      onChanged(e){
        this.events.thumbnail.file = e.raw
        console.log(e.raw)
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
