<template>
  <div>
    <div class="title">
      <h5 v-show="field.title!=''">{{field.title}}</h5>
    </div>
    <div>
      <span v-show="field.title!=''">{{field.content}}</span>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Description',
    props:['field']
  }
</script>
