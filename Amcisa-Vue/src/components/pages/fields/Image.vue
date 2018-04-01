<template>
  <div>
    <img :src="$store.state.baseUrl + '/api/download/' + field.path" style="max-width: 500px"/>
  </div>
</template>

<script>
export default {
  name: 'Image',
  props: ['field']
}
</script>
