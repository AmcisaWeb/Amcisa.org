<template>
  <div>
    <h4>
      {{field.title}}
    </h4>
    <el-input :placeholder="field.placeHolder" v-model="eventData.content" style="max-width: 300px"></el-input>
  </div>
</template>

<script>
  export default {
    name: 'TextInput',
    props: ['field'],
    data () {
      return {
        eventData:{
          id: this.field.id,
          content: ''
        }
      }
    },
    watch: {
      eventData: {
        handler: function (newData, oldData) {
          this.$emit('dataChanged',this.eventData)
        },
        deep:true
      }
    },
  }
</script>
