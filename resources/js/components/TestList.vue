<template>
    <div class="container mt-5">
        <table class="table shadow-lg">
            <thead>
                <tr>
                    <th scope="col">ID Testa</th>
                    <th scope="col">Korisnik</th>
                    <th scope="col">Naziv</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Izbrisi</th>
                    <th scope="col">Uredi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="test in tests">
                    <th scope="row">{{ test.id }}</th>
                    <th>{{ test.user.ime }}</th>
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
                    <td>
                        <button
                            type="button"
                            class="btn btn-sm btn-dark"
                            data-bs-toggle="modal"
                            :data-bs-target="'#exampleModal' + test.id"
                            data-bs-whatever="@getbootstrap"
                            @click="urediTest(test)"
                        >
                            Uredi
                        </button>
                        <div
                            class="modal fade"
                            :id="'exampleModal' + test.id"
                            tabindex="-1"
                            aria-labelledby="exampleModalLabel"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5
                                            class="modal-title"
                                            :id="'#exampleModal' + test.id"
                                        >
                                            Uredi test
                                        </h5>
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"
                                        ></button>
                                    </div>
                                    <div class="modal-body">
                                        <form
                                            @submit.prevent="
                                                updateTest(test.id)
                                            "
                                            method="POST"
                                        >
                                            <input
                                                type="hidden"
                                                v-model="this.POST"
                                            />
                                            <input
                                                type="hidden"
                                                name=""
                                                v-model="this.csrfToken"
                                            />
                                            <div class="mb-3">
                                                <label
                                                    for="recipient-name"
                                                    class="col-form-label"
                                                    >Ime:</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="recipient-name"
                                                    v-model="ispit.ime"
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    for="message-text"
                                                    class="col-form-label"
                                                    >Opis:</label
                                                >
                                                <textarea
                                                    class="form-control"
                                                    id="message-text"
                                                    v-model="ispit.opis"
                                                ></textarea>
                                            </div>
                                            <button
                                                type="submit"
                                                class="btn btn-primary w-100"
                                            >
                                                Uredi test
                                            </button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-dark w-100"
                                            data-bs-dismiss="modal"
                                        >
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
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
            user: [],
            ispit: {
                ime: "",
                opis: "",
            },
            csrfToken: "",
            POST: "",
            currentlekcijaId: null,
        };
    },
    created() {
        this.getTest();
    },
    mounted() {
        this.fetchCsrfToken();
    },
    methods: {
        fetchCsrfToken() {
            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    this.csrfToken = response.data.csrf_token;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
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
                    this.tests = this.tests.filter((test) => test.id !== id);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        urediTest(test) {
            this.currentlekcijaId = test.id;
            this.ispit.ime = test.ime;
            this.ispit.opis = test.opis;

            console.log(this.currentlekcijaId);
            $("#exampleModal" + test.id).modal("show");
        },
        updateTest(id) {
            console.log("Ime testa prije ažuriranja", this.ispit.ime);
            console.log("Opis testa prije ažuriranja", this.ispit.opis);
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post(`/updateTest/${id}`, {
                    ime: this.ispit.ime,
                    opis: this.ispit.opis,
                })
                .then((response) => {
                    this.poruka = response.data.poruka;
                    ;

                    const updatedTest = response.data.test;
                    const index = this.tests.findIndex(
                        (test) => test.id === this.currentlekcijaId
                    );
                    if (index !== -1) {

                        this.tests[index].ime = updatedTest.ime;
                        this.tests[index].opis = updatedTest.opis;
                    }
                });
            $("#exampleModal" + this.currentlekcijaId).modal("hide");
        },
    },
};
</script>

<style lang="scss" scoped></style>
