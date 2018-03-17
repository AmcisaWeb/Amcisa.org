<template>
  <div>
    <div class="title">
      <div :hidden="false" ref="title">
          <h5>
            {{data.field.title}}
            <a href="javascript:void(0)" @click="$refs.title.hidden=true; $refs.titleEdit.hidden=false"><i class="el-icon-edit-outline"></i></a>
          </h5>
      </div>
      <div :hidden="true" ref="titleEdit">
        <el-input
          size="medium"
          placeholder="Please input"
          v-model="data.field.title"/>
        <a href="javascript:void(0)" @click="$refs.title.hidden=false; $refs.titleEdit.hidden=true"><i class="el-icon-success"></i></a>
      </div>
    </div>
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
    name: 'UploadButton',
    props: ['id'],
    data () {
      return {
        data:{
          field:{
            id: '',
            type: this.$options.name,
            title: 'Upload your file',
            content: 'Upload',
            isInput: true,
            limit: true,  //single file if true, no limit if false, limit of number if 1,2,3...
            filter: '', //'jpeg|jpg|png'
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
