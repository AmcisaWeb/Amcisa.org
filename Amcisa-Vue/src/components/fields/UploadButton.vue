<template>
  <div>
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
  </div>
</template>

<script>
  export default {
    name: 'UploadButton',
    props: ['field'],
    data () {
      return {
        eventData:{
            id: this.field.id,
            files: []
        },
        fileTemplate: {
          filename:null,
          file: null
        }
      }
    },
    methods:{
      onChanged(e){
        const temp = Object.assign({}, this.fileTemplate)
        temp.file = e.raw;
        this.eventData.files.push(temp)
      },
      onRemoved(file, fileList){
        var len = this.eventData.files.length
        for (var i = 0; i < len; i++) {
          if(this.eventData.files[i].file.uid == file.uid)
          {
            this.eventData.files(i,1);
          }

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
