<template>
  <div>
    <video width="400" controls>
      <source :src="this.$store.state.baseUrl + '/api/download' + field.filename">
    </video>
  </div>
</template>

<script>
  export default {
    name: 'Video',
    props:['field']
  }
</script>
