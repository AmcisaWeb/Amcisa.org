<template>
  <div>
    <div>
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
      <div v-show="selected == 'Text Input'" >
        <span>Input Box: </span><el-input style="max-width: 300px; margin-left: auto; margin-right: auto" placeholder="Please input"></el-input>
      </div>
      <div v-show="selected == 'Text Area'" >
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
      <div v-show="selected == 'Image Selections'" style="max-width: 300px; margin-left: auto; margin-right: auto; text-align: left">
        <span>Image Selections: </span>
        <vue-select-image
          :dataImages="sampleImageSelections"
          h="130px"
          w="100px"></vue-select-image>
      </div>
      <div v-show="selected == 'Upload Button'" style="max-width: 500px; margin-left: auto; margin-right: auto; text-align: left">
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
      <div v-show="selected == 'Submit Button'" style="max-width: 500px; margin-left: auto; margin-right: auto; text-align: left">
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


    <ul class="list-group" v-sortable="{ handle: '.handle' }" >
      <li class="list-group-item" v-for="(field,index) in events.fields">
        <component :id="field.id" v-on:dataChanged="onFieldUpdated" v-bind:is="field.type"></component>
        <i class="handle"></i>
      </li>
    </ul>


    <button @click="testFunc">check value</button>
  </div>
</template>

<script>
  import axios from 'axios'
  import VueUploadComponent from 'vue-upload-component'
  import VueSelectImage from 'vue-select-image'
  import draggable  from 'vuedraggable'
  import Description from './fields/Description'
  import TextInput from './fields/TextInput'
  import TextArea from './fields/TextArea'
  import Selections from './fields/Selections'
  import ImageSelections from './fields/ImageSelections'
  import UploadButton from './fields/UploadButton'
  import SubmitButton from './fields/SubmitButton'


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
          thumbnail:'',
          description:'',
          page:'',
          fields:[]
        },
        template:{},
        test:[
          {id:'0', content:'this is one', secret:'1111'},
          {id:'58', content:'this is 222', secret:'222'},
          {id:'59', content:'this is 333', secret:'333'},
          {id:'60', content:'this is 444', secret:'444'},
          {id:'62', content:'this is 555', secret:'555'},
        ]
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
      testFunc(){
        console.log(this.events.fields)
      },
      onFieldUpdated(e){
        //this code is to update the appropriate this.events.fields according to id of e, these code can be improved. Note that forEach not support break, return.
        var i = 0
        var isEqual = false
        this.events.fields.forEach((f)=>{
          console.log(f.id + '  ==  ' + e.field.id)
          if(f.id == e.field.id){
            console.log('equal!!!!')
            isEqual = true
          }
          else if(!isEqual){
            i++
          }
        })
        if(i<this.events.fields.length){
          this.events.fields[i] = e.field
          console.log('this.events.fields[' + i + ']=  ' + e.field.id)
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
      OnChanged(e){
        console.log(e)
        this.files.push(e.raw)
      },
      OnSubmit(){
        console.log(this.files)
        var formData = new FormData()
        formData.append('file', this.files[0])
        formData.append('extension', 'jpeg')
        axios.post('/api/upload',
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        ).then(function (response) {
          console.log(response)
        })
          .catch(function () {
            console.log('FAILURE!!')
          })
      }
    },
    created () {
      axios.defaults.baseURL = this.$store.state.baseUrl
    }
  }
</script>
