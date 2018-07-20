<template>
  <div>
    <table class="table table-hover simple-table">
      <thead>
        <tr>
          <th v-for="(header,index) in columnHeaders" v-on:click="header.function ? header.function : ''" v-bind:key="index">
            {{header.text}}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in rows" v-bind:key="index">
          <td v-for="(col, index) in array(row)" v-bind:key="index">
            {{col}}
          </td>
        </tr>
        <tr v-if="rows.length == 0">
          <td :colspan="columnHeaders.length" style="padding: 10px;"> No result </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'UnickTable',

  props: {
    columnHeaders : { type: Array, required:true },
    rows : { type: Array, required:true },
  },

  data: () => ({
    public_path: location.origin,
  }),
  computed: {
    array: function(item){
      var arr = Object.keys(item);
      var result = [];

      for(var i = 0; i < arr.length; i++){
        result.push(item[arr[i]]);
      }

      return result;
    }
  },
  methods: {
    // 
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
