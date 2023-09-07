<template>
    <div>
      <table>
        <thead>
          <tr>
            <th>Korisnik</th>
            <th>Ukupni bodovi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(result, index) in results" :key="index">
            <td>{{ result.user.ime }}</td>
            <td>{{ result.totalBodova }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        results: [],
      };
    },
    created() {
      this.getResults();
    },
    methods: {
      getResults() {
        axios.get("/getResults").then((response) => {
          this.results = response.data.results;
        });
      },
    },
  };
  </script>
