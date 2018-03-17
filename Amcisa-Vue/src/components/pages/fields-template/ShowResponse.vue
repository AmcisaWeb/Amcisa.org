<template>
  <div>
    {{event.title}}
  </div>
</template>

<script>
  export default {
    name: 'ShowResponse',
    props:['id','event'],
    data () {
      return {
        data:{
          field:{
            id: '',
            type: this.$options.name,
            title: 'This is the title',
            isInput: false,
            selectedFieldId: ''
          }
        }
      }
    },
    watch: {
      data: {
        handler: function (newData, oldData) {
          this.$emit('dataChanged',this.data)
        },
        deep:true
      }
    },
    created(){
      this.data.field.id = this.id
      this.$emit('created',this.data)
    }
  }
</script>
