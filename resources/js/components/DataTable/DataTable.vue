<template>
  <div class="data-table">

    <table class="table">
      <thead>
      <tr>
        <th v-for="column in columns" :key="column"
            class="table-head">
          {{ column | columnHead }}
        </th>
      </tr>
      </thead>
      <tbody>
      <tr class="" v-if="tableData.length === 0">
        <td class="lead text-center" :colspan="columns.length + 1">No data found.</td>
      </tr>
      <tr v-for="data in tableData" :key="data.id" class="m-datatable__row" v-else>
        <td>{{ data.id }}</td>
        <td>{{ data.name }}</td>
        <td>
            <img v-img :src="data.images[0].path" alt="img" class="product-img">
        </td>
        <td>
          {{ data.desc }}
        </td>
        <td>
            <img src="https://proxy.duckduckgo.com/iu/?u=https%3A%2F%2Fsharpsnippets.files.wordpress.com%2F2013%2F12%2Feditsvg.png&f=1" class="edit-icon"/>
            <img src="https://proxy.duckduckgo.com/iu/?u=https%3A%2F%2Fcdn1.iconfinder.com%2Fdata%2Ficons%2Fflat-web-browser%2F100%2Fremove-button-512.png&f=1" class="delete-icon"/>
        </td>
        <!-- <td v-for="(value, key) in data" v-bind:key="key">{{ value }}</td> -->
      </tr>
      </tbody>

    </table>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'DataTable',
    props: {
        fetchUrl: { type: String, required: true },
        columns: { type: Array, required: true },
    },
    data() {
        return {
            tableData: []
        }
    },
    created() {
        return this.fetchData(this.fetchUrl)
    },
    methods: {
        fetchData(url) {
            axios.get(url)
                .then(data => {
                    this.tableData = data.data
                    console.log(this.tableData);
                })
        },
        /**
         * Get the serial number.
         * @param key
         * */
        serialNumber(key) {
            return key + 1;
        },
    },
    filters: {
        columnHead(value) {
            return value.split('_').join(' ').toUpperCase()
        }
    }
    
}
</script>

<style scoped>

</style>