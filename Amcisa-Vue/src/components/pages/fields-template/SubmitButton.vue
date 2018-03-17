<template>
  <div>
    <div class="content">
      <div :hidden="false" ref="content">
        <el-button>{{data.field.content}}</el-button>
        <a href="javascript:void(0)" @click="$refs.content.hidden=true; $refs.contentEdit.hidden=false"><i class="el-icon-edit-outline"></i></a>
      </div>
      <div :hidden="true" ref="contentEdit">
        <el-input
          size="mini"
          placeholder="Please input"
          v-model="data.field.content"/>
        <a href="javascript:void(0)" @click="$refs.content.hidden=false; $refs.contentEdit.hidden=true"><i class="el-icon-success"></i></a>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'SubmitButton',
    props: ['id'],
    data () {
      return {
        data:{
          field:{
            id: '',
            content:'Submit',
            type: this.$options.name,
            isInput: true
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
