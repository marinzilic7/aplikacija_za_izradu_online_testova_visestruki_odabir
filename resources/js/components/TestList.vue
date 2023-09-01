<template>
    <div class="container mt-5">
        <table class="table shadow-lg">
            <thead>
                <tr>
                    <th scope="col">ID Testa</th>
                    <th scope="col">Naziv</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Akcije</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="test in tests">
                    <th scope="row">{{ test.id }}</th>
                    <td>{{ test.ime }}</td>
                    <td>{{ test.opis }}</td>
                    <td>
                        <button
                            class="btn btn-sm btn-danger"
                            @click="izbrisiTest(test.id)"
                        >
                            Izbrisi
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            tests: [],
        };
    },
    created() {
        this.getTest();
    },
    methods: {
        getTest() {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .get("/getTest")
                .then((response) => {
                    this.tests = response.data.map((test) => ({
                        ...test,
                        created_at: new Date(
                            test.created_at
                        ).toLocaleDateString("hr-HR", {
                            day: "numeric",
                            month: "long",
                            year: "numeric",
                        }),
                    }));

                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        izbrisiTest(id) {
            axios
                .post(`/deleteTest/${id}`)
                .then((response) => {
                    this.poruka = response.data;
                    this.tests = this.tests.filter(
                        (test) => test.id !== id
                    );
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
