<template>
  <div class="simple-card">
    <div class="simple-card-header">
      Application Count Chart
    </div>
    <div class="simple-card-body">
      <div class="p-15">
        <div ref="event_period" class="input-group input-group-sm mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">Date Range</span>
          </div>
          <input type="text" class="form-control actual_range from" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">to</span>
          </div>
          <input type="text" class="form-control actual_range to" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </div>
      </div>
      <canvas ref="chart"></canvas>
      <unick-loader v-if="!finished" class="loader" />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
import Chart from 'chart.js'

export default {
  name: 'ApplicationCountLine',
  data : () =>({
    public_path: location.origin,
    finished: false,
    companies: [],
    from: new moment().subtract(1, 'month').format('YYYY-MM-D'),
    to: new moment().format('YYYY-MM-D'),
    chart: null
  }),
  methods: {
    async fetch(){
      this.finished = false;
      const {data} = await axios({
        url: '/api/reporting/recruiter/application/count/per/day',
        method: 'get',
        params: {date1: this.from, date2: this.to}
      })
      this.finished = true
      console.log(this.chart.data)
      this.chart.data.datasets[0].data = data.chart_data.data
      this.chart.data.labels = data.chart_data.dates
      this.chart.update()
    }
  },
  mounted(){
    this.chart = new Chart(this.$refs.chart, {
      type: 'bar',
      data: {
        datasets: [{
          label: 'Application Count',
          data: [],
          type: 'line'
        }],
        labels: []
      },
      options: {}
    })
    // jQuery(this.$refs['event_period']).find('.from').datepicker('update', new moment().subtract(1, 'month').format('YYYY-MM-D'));
    jQuery(this.$refs['event_period']).find('.from').val(this.from);
    jQuery(this.$refs['event_period']).find('.to').val(this.to);
    jQuery(this.$refs['event_period']).datepicker({
        inputs: jQuery('.actual_range'),
        format : "yyyy-mm-dd"
    });

    var $this = this
    jQuery(this.$refs['event_period']).find('.from').datepicker().on('changeDate', function(e){
      $this.from = jQuery(this).val()
      $this.fetch();
    })
    jQuery(this.$refs['event_period']).find('.to').datepicker().on('changeDate', function(e){
      $this.to = jQuery(this).val()
      $this.fetch();
    })

    this.fetch();
  }
}
</script>
<style lang="scss" scoped>
.loader{
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translateX(-50%) translateY(-50%);
}
</style>


