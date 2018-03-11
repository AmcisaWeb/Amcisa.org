<template>
  <div>
    this is imgage selection
  </div>
</template>

<script>
  export default {
    name: 'TextArea',
    props: ['id'],
    data () {
      return {
        data:{
          field:{
            id: '',
            type: this.$options.name,
            title: 'Enter the text',
            placeHolder: 'Enter the text',
            isInput: true,
            text: '',
            limit: false
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
