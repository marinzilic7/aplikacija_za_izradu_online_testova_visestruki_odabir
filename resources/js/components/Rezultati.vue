<template>
    <div class="container mt-5 col-lg-5">
        <table class="table border shadow-lg">
            <thead>
                <tr>

                    <th scope="col">Student</th>
                    <th scope="col">Bodovi</th>

                </tr>
            </thead>
            <tbody>
                <tr v-for="(totalPoints, userId) in totals" :key="userId">

                    <td>{{ totalPoints.ime }}</td>
                    <td>{{ totalPoints.ukupniBodovi }}</td>

                </tr>

            </tbody>
        </table>
        <button class="btn btn-outline-danger w-100" @click="deleteAllRez">Izbrisi sve rezultate</button>
    </div>

</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            totals: {},
            message:'',
        };
    },
    created() {
        this.getRez();
    },
    methods: {
        getRez() {
            axios
                .get("/getRez")
                .then((response) => {
                    this.totals = response.data.totals;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        deleteAllRez(){
            axios.post("/deleteRez").then((response) => {
                this.message = response.data;
                this.getRez();
            })
        }
    },
};
</script>
