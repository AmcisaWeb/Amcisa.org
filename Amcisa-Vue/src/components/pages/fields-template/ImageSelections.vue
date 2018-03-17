<template>
  <div>
    <el-upload
      :auto-upload="false"
      action="https://jsonplaceholder.typicode.com/posts/"
      list-type="picture-card"
      :on-change="onChanged"
      :on-remove="onRemoved">
      <i class="el-icon-plus"></i>
    </el-upload>
    <el-dialog :visible.sync="dialogVisible">
      <img width="100%" :src="dialogImageUrl" alt="">
    </el-dialog>
  </div>
</template>

<script>

export default {
  name: 'ImageSelections',
  props: ['id'],
  data () {
    return {
      data:{
        field:{
          id: '',
          type: this.$options.name,
          title: 'Please Select',
          isInput: true,
          selections: [],
          isMultiple: false,
          photoRatio: null
        }
      },
      template:{
        selection: {filename:'', text:'',file:null}
      }
    }
  },
  methods:{
    onChanged(e){
      const selection = Object.assign({}, this.template.selection)
      selection.file = e.raw
      this.data.field.selections.push(selection)
    },
    onRemoved(file, fileList){
      var len = this.data.field.selections.length
      for (var i = 0; i < len; i++) {
        if(this.data.field.selections[i].file.uid == file.uid)
        {
          this.data.field.selections.splice(i,1);
          console.log('remove  ' + i)
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
