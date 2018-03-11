<template>
  <div>

  </div>
</template>

<script>
  export default {
    name: 'TextInput',
    props: ['id'],
    data () {
      return {
        data:{
          field:{
            id: '',
            type: this.$options.name,
            title: 'Input the text',
            placeHolder: 'This is placeholder',
            isInput: true,
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
