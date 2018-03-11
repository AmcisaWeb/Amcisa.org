<template>
  <div>
    <div class="title">
      <h5 v-show="field.title!=''">{{field.title}}</h5>
    </div>
    <vue-select-image :dataImages="dataImage"
                      @onselectimage="onSelectImage"
                      style="margin: 10%; margin-bottom: 0; margin-top: 5%">
    </vue-select-image>
  </div>
</template>

<script>
import VueSelectImage from 'vue-select-image'

export default {
  name: 'ImageSelections',
  props:['field'],
  data () {
    return {
      eventData:{
        id: this.field.id,
        content: ''
      },
      dataImage: []
    }
  },
  components: { VueSelectImage },
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
  created(){
    var i = 0;
    this.field.selections.forEach((e)=>{
      i++
      this.dataImage.push({id: i,src: this.$store.state.baseUrl + '/api/download' + e.filename})
    })
  }
}
</script>
