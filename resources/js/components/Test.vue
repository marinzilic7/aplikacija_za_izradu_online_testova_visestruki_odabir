<template>
    <div class="container mt-5">
        <div
            class="accordion accordion-flush shadow-lg"
            id="accordionFlushExample"
        >
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseOne"
                        aria-expanded="false"
                        aria-controls="flush-collapseOne"
                    >
                        Dodaj test
                    </button>
                </h2>
                <div
                    id="flush-collapseOne"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordionFlushExample"
                >
                    <div class="accordion-body">
                        <form @submit.prevent="dodajTest()">
                            <input type="hidden" v-model="this.POST" />
                            <input
                                type="hidden"
                                name=""
                                v-model="this.csrfToken"
                            />
                            <div class="mb-3">
                                <label
                                    for="exampleInputEmail1"
                                    class="form-label"
                                    >Ime testa</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    v-model="test.ime"
                                />
                            </div>
                            <p v-if="errors.ime" class="text-danger">
                                {{ errors.ime[0] }}
                            </p>
                            <div class="mb-3">
                                <label
                                    for="exampleInputPassword1"
                                    class="form-label"
                                    >Opis testa</label
                                >
                                <textarea
                                    type="text"
                                    class="form-control"
                                    id="exampleInputPassword1"
                                    v-model="test.opis"
                                />
                            </div>
                            <p v-if="errors.opis" class="text-danger">
                                {{ errors.opis[0] }}
                            </p>
                            <button type="submit" class="btn btn-primary">
                                Dodaj
                            </button>
                            <div
                                v-if="successTest"
                                class="alert alert-info mt-4 w-25 m-auto text-center"
                            >
                                {{ poruka }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            test: {
                ime: "",
                opis: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},
            poruka: "",
            successTest: false,
        };
    },
    computed() {
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
        dodajTest() {
            const Test = {
                ime: this.test.ime,
                opis: this.test.opis,
            };

            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;

            axios
                .post("/addTest", Test)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.successTest = true;
                    setTimeout(() => {
                        this.successTest = false; // Sakrij poruku
                    }, 1500); // 1500 milisekundi
                    this.form = {
                        ime: "",
                        opis: "",
                    };
                    this.errors = {};
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                        this.postojiEmail = true;
                    } else {
                        console.log(error);
                    }
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
