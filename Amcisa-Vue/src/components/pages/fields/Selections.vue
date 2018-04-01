<template>
  <div>
    <el-dropdown @command="(e)=> {eventData.content = e}">
      <el-button type="primary">
        <div v-if="eventData.content == ''">
          {{field.title}}<i class="el-icon-arrow-down el-icon--right"></i>
        </div>
        <div v-else>
          {{eventData.content}}<i class="el-icon-arrow-down el-icon--right"></i>
        </div>
      </el-button>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item v-for="s in field.selections" :command="s">{{s}}</el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>
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
<<<<<<< HEAD
<<<<<<< HEAD
  computed:{
    dropdownSize(){
      if(this.field.selections.length<15) return 'medium'
      else if(this.field.selections.length<23) return 'small'
      else return 'mini'
    }
  },
=======
>>>>>>> parent of 56c04dc... Fix DropDown Bugs
=======
>>>>>>> parent of 56c04dc... Fix DropDown Bugs
  created(){
      console.log(this.field)
  }
}
</script>

