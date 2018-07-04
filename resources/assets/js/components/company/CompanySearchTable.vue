<template>
  <div class="simple-card">
    <div class="simple-card-header">
      Company List
    </div>
    <table class="table table-hover">
      <tbody>
        <tr>
          <th>ID</th>
          <th>User</th>
          <th>Date</th>
          <th>Status</th>
          <th>Reason</th>
        </tr>
        <tr>
          <td>183</td>
          <td>John Doe</td>
          <td>11-7-2014</td>
          <td><span class="label label-success">Approved</span></td>
          <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
        </tr>
        <tr>
          <td>219</td>
          <td>Alexander Pierce</td>
          <td>11-7-2014</td>
          <td><span class="label label-warning">Pending</span></td>
          <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
        </tr>
        <tr>
          <td>657</td>
          <td>Bob Doe</td>
          <td>11-7-2014</td>
          <td><span class="label label-primary">Approved</span></td>
          <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
        </tr>
        <tr>
          <td>175</td>
          <td>Mike Doe</td>
          <td>11-7-2014</td>
          <td><span class="label label-danger">Denied</span></td>
          <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'CompanySearchTable',

  props: {
    size: { type: String, default: null },
  },

  data: () => ({
    public_path: location.origin,
    icons: {
      school: { img: window.config.public_location + "images/school.png"},
      company: { img: window.config.public_location + "images/company.png"},
    }
  }),
  methods: {
    // 
  },
  mounted(){
    // 
  }
}
</script>
