<template>
  <div>
    <img style="max-width: 80%" :src="$store.state.baseUrl + '/api/download' + field.filename">
  </div>
</template>

<script>
export default {
  name: 'Picture',
  props: ['field']
}
</script>
