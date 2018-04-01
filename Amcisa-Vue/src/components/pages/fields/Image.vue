<template>
  <div>
    <img style="max-width: 500px" :src="$store.state.baseUrl + '/api/download/' + '/32_Am斯卡提名/15207150695007.jpg'">
    <img style="max-width: 500px" :src="$store.state.baseUrl + '/api/download/' + field.filename">
  </div>
</template>

<script>
export default {
  name: 'Image',
  props: ['field']
}
</script>
