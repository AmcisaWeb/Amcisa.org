<template>
  <div>
    <div class="title">
      <div :hidden="false" ref="title">
        <h5>{{data.field.title}}</h5>
        <a href="javascript:void(0)" @click="$refs.title.hidden=true; $refs.titleEdit.hidden=false"><i class="el-icon-edit-outline"></i></a>
      </div>
      <div :hidden="true" ref="titleEdit">
        <el-input
          size="medium"
          placeholder="Please input"
          v-model="data.field.title"/>
        <a href="javascript:void(0)" @click="$refs.title.hidden=false; $refs.titleEdit.hidden=true"><i class="el-icon-success"></i></a>
      </div>
    </div>
    <div>
      <el-radio v-model="radio7" label="1" border>Option A</el-radio>
      <el-radio v-model="radio7" label="2" border>Option B</el-radio>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Selections',
    props: ['id'],
    data () {
      return {
        data:{
          field:{
            id: '',
            type: this.$options.name,
            title: 'Please select',
            isInput: true,
            isMultiple: false,
            selections: []
          }
        },
        template: {
          selection: {id:'', text:''}
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
