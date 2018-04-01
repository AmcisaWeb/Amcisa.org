<template>
  <div>
    <img :src="field.path" style="max-width: 500px"/>
  </div>
</template>

<script>
  export default {
    name: 'Description',
    props:['field']
  }
</script>
