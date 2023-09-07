<template>
    <div class="container mt-5 d-flex justify-content-center">
        <div class="row col-lg-4">
            <select v-model="selectedTestId" @change="selectTest">
                <option disabled selected value="">Odaberi test</option>
                <option v-for="test in testovi" :value="test.id">
                    {{ test.ime }}
                </option>
            </select>
        </div>
    </div>
    <div>
        <div class="container mt-5" v-if="showTest">
            <div class="d-flex justify-content-center row">
                <div class="col-md-10 col-lg-10">
                    <div class="border shadow-lg">
                        <div class="question bg-white p-3 border-bottom">
                            <div
                                v-if="!isTestFinished"
                                class="d-flex flex-row justify-content-between align-items-center"
                            >
                                <h4>{{ tests.ime }}</h4>
                                <p>
                                    <span class="text-warning">{{
                                        trenutniBroj
                                    }}</span>
                                    od
                                    {{ tests.questions.length }}
                                </p>
                            </div>
                            <div v-if="isTestFinished">
                                <p>
                                    <span class="font-monospace"
                                        >Korisnik:</span
                                    >
                                    {{ tests.user.ime }}
                                </p>
                                <p>
                                    <span class="font-monospace"
                                        >Ime testa:</span
                                    >
                                    {{ tests.ime }}
                                </p>
                                <span class="font-monospace">Pitanja:</span>
                                <ul>
                                    <li v-for="pitanje in pitanja">
                                        {{ pitanje }}
                                    </li>
                                </ul>
                                <p v-if="showResults">
                                    <span class="font-monospace"
                                        >Rezultat:</span
                                    >
                                    {{ totalPoints }} bodova od
                                    {{ zbrojiBodove }}
                                </p>
                                <p v-if="showNegativeResult">
                                    <span class="font-monospace">Rezultat:</span
                                    >{{ totalPoints }} bodova od
                                    {{ zbrojiBodove }}
                                </p>
                                <button
                                    @click="newTest"
                                    class="btn btn-primary"
                                >
                                    Novi test
                                </button>
                            </div>
                            <p v-if="!isTestFinished">{{ tests.opis }}</p>
                            <div
                                v-if="!isTestFinished"
                                class="d-flex justify-content-between"
                            >
                                <p>
                                    Bodovi:
                                    <span class="text-success">{{
                                        tests.questions[currentQuestionIndex]
                                            .bodovi
                                    }}</span>
                                </p>
                                <p>
                                    Ukupno bodova:
                                    <span class="text-success">{{
                                        zbrojiBodove
                                    }}</span>
                                </p>
                            </div>
                        </div>
                        <div
                            v-if="!isTestFinished"
                            class="question bg-white p-3 border-bottom"
                        >
                            <div
                                class="d-flex flex-row align-items-center question-title"
                            >
                                <h5
                                    class="mt-1 ml-2"
                                    v-if="tests.questions.length > 0"
                                >
                                    <span class="text-success"> Pitanje: </span>
                                    {{
                                        tests.questions[currentQuestionIndex]
                                            .pitanje
                                    }}
                                </h5>
                            </div>
                            <div
                                v-for="answer in tests.questions[
                                    currentQuestionIndex
                                ].answers"
                                :key="answer.id"
                            >
                                <label class="radio">
                                    <input
                                        :disabled="
                                            answeredQuestions.includes(
                                                currentQuestionIndex
                                            )
                                        "
                                        type="radio"
                                        :name="
                                            'answer_' +
                                            tests.questions[
                                                currentQuestionIndex
                                            ].id
                                        "
                                        :value="answer.tocanOdgovor"
                                        v-model="
                                            selectedAnswerId[
                                                currentQuestionIndex
                                            ]
                                        "
                                    />
                                    {{ answer.odgovor }}
                                    {{ answer.tocanOdgovor }}
                                </label>
                            </div>
                        </div>
                        <div
                            v-if="!isTestFinished"
                            class="d-flex flex-row justify-content-between align-items-center p-3 bg-white"
                        >
                            <button
                                :disabled="isTestFinished"
                                class="btn btn-primary d-flex align-items-center btn-danger"
                                type="button"
                                @click="previousQuestion"
                            >
                                Previous
                            </button>
                            <div>
                                <button
                                    :disabled="
                                        answeredQuestions.includes(
                                            currentQuestionIndex
                                        )
                                    "
                                    class="btn btn-primary btn-sm me-2"
                                    @click="spremiOdgovor()"
                                >
                                    Spremi
                                </button>

                                <button
                                    v-if="
                                        this.currentQuestionIndex ===
                                        this.tests.questions.length - 1
                                    "
                                    class="btn btn-warning btn-sm"
                                    @click="prikaziRezultat()"
                                >
                                    Zavrsi test
                                </button>
                                <button
                                    v-else
                                    class="btn btn-sm btn-primary border-success align-items-center btn-success"
                                    type="button"
                                    @click="nextQuestion"
                                >
                                    Next
                                </button>

                                <span v-if="isAnswerCorrect">
                                    Odgovor je točan
                                </span>
                                <span v-if="pokaziOdgovor">
                                    Odgovor je netocan
                                </span>
                            </div>
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
            tests: [],
            testovi: [],
            currentQuestionIndex: 0, // Dodajte trenutni indeks pitanja
            selectedTestId: "",
            showTest: false,
            trenutniBroj: 1,
            sumPoints: null,
            zbrojiBodove: null,
            selectedAnswerId: [],
            isAnswerCorrect: false,
            pokaziOdgovor: false,
            testAnswer: {
                correct: "",
            },
            answeredQuestions: [],
            isAnswered: false,
            totalPoints: 0,
            isTestFinished: false,
            showResults: false,
            showNegativeResult: false,

            pitanja: [],



        };
    },
    created() {
        this.dohvatiTestove();
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
        dohvatiTestove() {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .get("/getTest")
                .then((response) => {
                    this.testovi = response.data.map((test) => ({
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

        nextQuestion() {
            this.pitanja.push(
                this.tests.questions[this.currentQuestionIndex].pitanje
            );

            if (this.currentQuestionIndex < this.tests.questions.length - 1) {
                this.tests.questions[
                    this.currentQuestionIndex
                ].isAnswered = true;

                this.tests.questions[
                    this.currentQuestionIndex + 1
                ].isAnswered = false;
                this.currentQuestionIndex++;
                this.trenutniBroj++;
            }
        },

        previousQuestion() {
            if (this.currentQuestionIndex > 0) {
                this.currentQuestionIndex--;
                this.trenutniBroj--;
            }
        },

        selectTest() {
            // Učitajte pitanja i odgovore za odabrani test na osnovu selectedTestId
            this.currentQuestionIndex = 0;
            this.trenutniBroj = 1;
            this.zbrojiBodove = null;

            if (this.selectedTestId !== null) {
                axios
                    .get(`/dohvatiTestove/${this.selectedTestId}`)
                    .then((response) => {
                        this.tests = response.data;

                        this.tests.questions.forEach((question) => {
                            question.isAnswered = false;

                            this.zbrojiBodove =
                                question.bodovi + this.zbrojiBodove;
                        });

                        this.showTest = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },

        spremiOdgovor() {
            console.log("Prije novog spremanja", this.totalPoints);
            const selectedAnswerId = this.selectedAnswerId;
            /* console.log("ID ODGOVORA", selectedAnswerId); */
            const OdgovorNaPitanje =
                this.selectedAnswerId[this.currentQuestionIndex];
            let isCurrentAnswerCorrect = false; // Dodajte varijablu za trenutni odgovor
            selectedAnswerId.forEach((element) => {
                if (element == "Da") {
                    isCurrentAnswerCorrect = true; // Postavite na true ako je odgovor točan
                } else {
                    isCurrentAnswerCorrect = false;
                }
            });

            if (isCurrentAnswerCorrect) {
                this.isAnswerCorrect = true;
                this.totalPoints +=
                    this.tests.questions[this.currentQuestionIndex].bodovi;
                console.log(this.totalPoints);
            } else if (isCurrentAnswerCorrect) {
                this.isAnswerCorrect = false;
                this.pokaziOdgovor = true;
                console.log("NIJE TOCNO BRE");
            }

            this.answeredQuestions.push(this.currentQuestionIndex);
            console.log("--------------------------------------------");
            console.log("ID TESTAAAAAAAAAAA", this.tests.id);
            console.log(
                "PITANJE JE",
                this.tests.questions[this.currentQuestionIndex].pitanje
            );
            console.log("ODGOVOR NA PITANJE JE", OdgovorNaPitanje);
            console.log("Bodova po pitanju", this.totalPoints);


            const Podaci = {
                test_id:this.tests.id,
                pitanje:this.tests.questions[this.currentQuestionIndex].pitanje,
                odgovor:OdgovorNaPitanje,
                zbrojBodova:this.totalPoints,
            };

            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;

            axios
                .post("/rezultat", Podaci)
                .then((response) => {
                    this.poruka = response.data.poruka;

                    this.form = {
                        test_id: "",
                        pitanje: "",
                        odgovor: "",
                        zbrojBodova: "",

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

        prikaziRezultat() {
            let rez = this.zbrojiBodove / 2;
            console.log(this.tests.questions.length);
            console.log("Ovo je 9 / 3 ", rez);
            if (this.totalPoints >= rez) {
                this.showResults = true;
            } else {
                this.showNegativeResult = true;
            }
            this.isTestFinished = true;

            console.log(this.pitanja);
        },

        newTest() {
            window.location.reload();
        },
    },
};
</script>

<style lang="scss" scoped></style>
