<template>
  <div>
    <h1 class="title" style="font-size: 6rem;">[AMCISA]</h1>
    <router-link to="/info">
      <el-button style="width: 300px; margin-bottom: 10px">升学资讯</el-button>
    </router-link>
    <about-us></about-us>
    <login-form/>
    <events/>
  </div>
</template>

<script>
import axios from 'axios'
import LoginForm from './LoginForm'
import Events from './Events'
import AddEvent from './AddEvent'
import AboutUs from './AboutUs'
import Pusher from 'pusher-js' // import Pusher

export default {
  name: 'Home',
  data () {
    return {
      file: '',
      timer: ''
    }
  },
  components: {
    AboutUs,
    'login-form': LoginForm,
    'events': Events,
    'add-event': AddEvent,
    'about-us': AboutUs
  },
  methods: {
    /*
      Submits the file to the server
    */
    submitFile () {
      /*
          Initialize the form data
      */
      var formData = new FormData()
      /*
          Add the form data we need to submit
      */
      formData.append('file', this.file)
      formData.append('extension', 'jpeg')
      /*
        Make the request to the POST /single-file URL
      */
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
    },
    /*
      Handles a change on the file upload
    */
    handleFileUpload () {
      this.file = this.$refs.file.files[0]
    }

  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .title {
    color: #f35626;
    background-image: -webkit-linear-gradient(92deg,#f35626,#feab3a);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    -webkit-animation: hue 30s infinite linear;
  }
  @-webkit-keyframes hue {
    from {
      -webkit-filter: hue-rotate(0deg);
    }

    to {
      -webkit-filter: hue-rotate(-360deg);
    }
  }
</style>
