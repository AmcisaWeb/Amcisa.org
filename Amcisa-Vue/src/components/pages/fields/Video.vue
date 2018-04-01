<template>
  <div>
    <video width="400" controls>
      <source :src="$store.state.baseUrl + '/api/download' + field.filename">
      Your browser does not support HTML5 video.
    </video>
  </div>
</template>

<script>
  export default {
    name: 'Video',
    props: ['field']
  }
</script>

