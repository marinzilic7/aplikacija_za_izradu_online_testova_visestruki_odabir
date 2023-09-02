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
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseThree"
                        aria-expanded="false"
                        aria-controls="collapseThree"
                    >
                        Dodaj pitanje
                    </button>
                </h2>
                <div
                    id="collapseThree"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample"
                >
                    <div class="accordion-body">
                        <div>
                            <form @submit.prevent="dodajPitanje()">
                                <input type="hidden" v-model="this.POST" />
                                <input
                                    type="hidden"
                                    name=""
                                    v-model="this.csrfToken"
                                />
                                <div class="form-group">
                                    <label for="exampleInputEmail1"
                                        >Odaberi test</label
                                    >
                                    <select
                                        class="form-select form-select-sm"
                                        aria-label="Small select example"
                                        v-model="pitanje.test_id"
                                    >
                                        <option
                                            v-for="test in tests"
                                            :value="test.id"
                                            :key="test.id"
                                        >
                                            {{ test.ime }}
                                        </option>
                                    </select>
                                    <p
                                        v-if="errors.test_id"
                                        class="text-danger"
                                    >
                                        {{ errors.test_id[0] }}
                                    </p>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="exampleInputEmail1"
                                        >Pitanje</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="exampleInputEmail1"
                                        aria-describedby="emailHelp"
                                        placeholder="Unesite pitanje"
                                        v-model="pitanje.pitanje"
                                    />
                                </div>
                                <p v-if="errors.pitanje" class="text-danger">
                                    {{ errors.pitanje[0] }}
                                </p>
                                <div class="form-group mt-3">
                                    <label for="exampleInputEmail1"
                                        >Odgovor 1</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="exampleInputEmail1"
                                        aria-describedby="emailHelp"
                                        placeholder="Unesite odgovor"
                                        v-model="pitanje.odgovor1"
                                    />
                                </div>
                                <p v-if="errors.odgovor1" class="text-danger">
                                    {{ errors.odgovor1[0] }}
                                </p>
                                <div class="form-group mt-3">
                                    <label for="exampleInputEmail1"
                                        >Odgovor 2</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="exampleInputEmail1"
                                        aria-describedby="emailHelp"
                                        placeholder="Unesite odgovor"
                                        v-model="pitanje.odgovor2"
                                    />
                                </div>
                                <p v-if="errors.odgovor2" class="text-danger">
                                    {{ errors.odgovor2[0] }}
                                </p>
                                <div class="form-group mt-3">
                                    <label for="exampleInputEmail1"
                                        >Odgovor 3</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="exampleInputEmail1"
                                        aria-describedby="emailHelp"
                                        placeholder="Unesite odgovor"
                                        v-model="pitanje.odgovor3"
                                    />
                                </div>
                                <p v-if="errors.odgovor3" class="text-danger">
                                    {{ errors.odgovor3[0] }}
                                </p>
                                <button
                                    type="submit"
                                    class="btn btn-primary mt-3 w-100"
                                >
                                    Dodaj pitanje
                                </button>
                                <div
                                    v-if="successQuestion"
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
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            /* TEST */
            test: {
                ime: "",
                opis: "",
            },

            tests: [],
            csrfToken: "",
            POST: "",
            errors: {},
            poruka: "",
            successTest: false,

            /* PITANJE  */
            pitanje: {
                test_id: "",
                pitanje: "",
                odgovor1: "",
                odgovor2: "",
                odgovor3: "",
            },
            successPitanje: false,
        };
    },
    computed() {
        this.fetchCsrfToken();
    },
    created() {
        this.getTest();
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

        dodajPitanje() {
            const Pitanje = {
                test_id: this.pitanje.test_id,
                pitanje: this.pitanje.pitanje,
                odgovor1: this.pitanje.odgovor1,
                odgovor2: this.pitanje.odgovor2,
                odgovor3: this.pitanje.odgovor3,
            };

            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;

            axios
                .post("/addQuestion", Pitanje)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.successQuestion = true;
                    setTimeout(() => {
                        this.successQuestion = false; // Sakrij poruku
                    }, 1500);
                    this.form = {
                        test_id: "",
                        pitanje: "",
                        odgovor1: "",
                        odgovor2: "",
                        odgovor3: "",
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
