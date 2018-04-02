<template>
  <div>

    <el-select v-model="eventData.content" :placeholder="field.title">
      <el-option
        v-for="s in field.selections"
        :key="s"
        :label="s"
        :value="s">
      </el-option>
    </el-select>





  </div>
</template>

<script>
  export default {
    name: 'Selections',
    props:['field','currentEventId'],
    data () {
      return {
        eventData:{
          id: this.field.id,
          content: ''
        }
      }
    },
    methods:{
      onSelectImage(selected){
        var len = (this.$store.state.baseUrl + '/api/download/').length
        this.eventData.content = selected.src.substring(len)
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
    computed:{
      dropdownSize(){
        if(this.field.selections.length<15) return 'medium'
        else if(this.field.selections.length<23) return 'small'
        else return 'mini'
      }
    },
    created(){
      console.log(this.field)
    }
  }
</script>

