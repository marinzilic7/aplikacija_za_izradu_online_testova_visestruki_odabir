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
                                        >Dodaj pitanje u test</label
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
                                    >Koliko pitanje ima bodova?</label
                                >
                                <input
                                    type="number"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="Unesite odgovor za odabrano pitanje"
                                    v-model="pitanje.bodovi"
                                />
                            </div>
                                <button
                                    type="submit"
                                    class="btn btn-primary mt-3 w-100"
                                >
                                    Dodaj pitanje u test
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
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo"
                        aria-expanded="false"
                        aria-controls="collapseTwo"
                    >
                        Dodaj odgovor
                    </button>
                </h2>
                <div
                    id="collapseTwo"
                    class="accordion-collapse collapse"
                    data-bs-parent="#accordionExample"
                >
                    <div class="accordion-body">
                        <form @submit.prevent="dodajOdgovor()">
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
                                    v-model="answer.test_id"
                                >
                                    <option
                                        v-for="test in tests"
                                        :value="test.id"
                                        :key="test.id"
                                    >
                                        {{ test.ime }}
                                    </option>
                                </select>
                                <p v-if="errors.test_id" class="text-danger">
                                    {{ errors.test_id[0] }}
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"
                                    >Odaberi pitanje</label
                                >
                                <select
                                    class="form-select form-select-sm"
                                    aria-label="Small select example"
                                    v-model="answer.question_id"
                                >
                                    <option
                                        v-for="pitanje in pitanja"
                                        :value="pitanje.id"
                                        :key="pitanje.id"
                                    >
                                        {{ pitanje.pitanje }}
                                    </option>
                                </select>
                                <p v-if="errors.test_id" class="text-danger">
                                    {{ errors.test_id[0] }}
                                </p>
                            </div>
                            <div class="form-group mt-3">
                                <label for="exampleInputEmail1"
                                    >Dodaj odgovor</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="Unesite odgovor za odabrano pitanje"
                                    v-model="answer.odgovor"
                                />
                            </div>
                            <p v-if="errors.odgovor" class="text-danger">
                                {{ errors.odgovor[0] }}
                            </p>

                            <div class="form-group mt-3">
                                <label for="exampleInputEmail1"
                                    >Tocan odgovor?</label
                                >
                                <select

                                    v-model="answer.tocanOdgovor"
                                >

                                    <option value="Da">Da</option>
                                    <option value="Ne">Ne</option>
                                </select>
                                <p
                                    v-if="errors.tocanOdgovor"
                                    class="text-danger"
                                >
                                    {{ errors.tocanOdgovor[0] }}
                                </p>
                            </div>
                            <button
                                type="submit"
                                class="btn btn-primary mt-3 w-100"
                            >
                                Dodaj odgovor u test
                            </button>
                            <div
                                v-if="successAnswer"
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
                bodovi:"",
            },

            pitanja: [],
            successPitanje: false,


            /* Odgovor */

            answer: {
                question_id: "",
                test_id: "",
                odgovor: "",
                tocanOdgovor: "",

            },

            successAnswer: false,
        };
    },
    computed() {
        this.fetchCsrfToken();
    },
    created() {
        this.getTest();
        this.getPitanje();
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
                    this.getTest();
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
                bodovi: this.pitanje.bodovi,
            };

            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;

            axios
                .post("/addQuestion", Pitanje)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.successQuestion = true;
                    this.getPitanje();
                    setTimeout(() => {
                        this.successQuestion = false; // Sakrij poruku
                    }, 1500);
                    this.form = {
                        test_id: "",
                        pitanje: "",
                        bodovi:"",
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

        getPitanje() {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .get("/getPitanje")
                .then((response) => {
                    this.pitanja = response.data.map((pitanje) => ({
                        ...pitanje,
                        created_at: new Date(
                            pitanje.created_at
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

        dodajOdgovor() {
            const Odgovor = {
                question_id: this.answer.question_id,
                test_id: this.answer.test_id,
                odgovor: this.answer.odgovor,
                tocanOdgovor: this.answer.tocanOdgovor,

            };

            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;

            axios
                .post("/addAnswer", Odgovor)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.successAnswer = true;
                    this.getodgovor();
                    setTimeout(() => {
                        this.successAnswer = false; // Sakrij poruku
                    }, 1500);
                    this.form = {
                        question_id: "",
                        test_id: "",
                        odgovor: "",
                        tocanOdgovor: "",

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
