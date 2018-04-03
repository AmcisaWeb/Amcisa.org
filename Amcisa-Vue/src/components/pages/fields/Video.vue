<template>
  <div>
    <video width="80%" controls>
      <source :src="this.$store.state.baseUrl + '/api/download' + field.filename">
      If video unable to play, click: {{this.$store.state.baseUrl + '/api/download' + field.filename}}
    </video>

  </div>
</template>

<script>
  export default {
    name: 'Video',
    props:['field']
  }
</script>
