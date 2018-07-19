<template>
  <div>
    <el-button style="width: 300px; margin-bottom: 10px" @click="dialogVisible = true">关于我men</el-button>
    <el-dialog
      title="关于我们"
      :visible.sync="dialogVisible"
      width="90%">
      <span>{{aboutUs}}</span>
      <span slot="footer" class="dialog-footer">
    <el-button type="primary" @click="dialogVisible = false">OK</el-button>
    </span>
      </el-dialog>
  </div>
</template>

<script>
export default {
  name: 'AboutUs',
  data () {
    return {
      aboutUs: '成立于1983年，由就读于新加坡国立大学(NUS)以及南洋理工大学(NTU)的独中生毕业生组成。 本联谊会主要维系及增进独中生之间的感情，与董教总及各独中保持联络以提供新加坡大学的最新资料，协助新生适应大学生。每年AMCISA除了办如中秋晚会或新春晚会等的活动外，还会在七月中旬办迎新营，协助即将前来大学的独中生们处理学生证的申请、身体检查、贷款等繁杂手续。',
      dialogVisible: false

    }
  }
}
</script>
