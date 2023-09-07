<template>

    <div class="container mt-5 d-flex justify-content-center">
        <div class="row col-lg-4">
            <div v-if="!isLoggedIn" class="alert alert-warning">Obavezna registracija ili  prijava</div>
            <select :disabled="workingTest" v-model="selectedTestId" @change="selectTest">
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
                                <h6>{{ tests.ime }}</h6>
                                <p>
                                    <span class="text-warning">{{
                                        trenutniBroj
                                    }}</span>
                                    od
                                    {{ tests.questions.length }}
                                </p>
                            </div>
                            <div>
                                <div v-if="isTestFinished">
                                    <ul>
                                        <h3>Korisnik : {{ tests.user.ime }}</h3>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Pitanje</th>
                                                    <th scope="col">Odgovor</th>
                                                    <th scope="col">Bodovi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="result in results"
                                                    :key="result.id"
                                                >
                                                    <td>
                                                        {{ result.pitanje }}
                                                    </td>
                                                    <td v-if="(result.odgovor == 'Da')">
                                                        <p class="text-success">Odgovor točan</p>
                                                    </td>
                                                    <td v-else>
                                                        <p class="text-danger">Odgovor nije točan</p>
                                                    </td>
                                                    <td>
                                                        {{ result.zbrojBodova }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div
                                            class="d-flex justify-content-between"
                                        >
                                            <p>
                                                Ukupan zbroj bodova
                                                <span class="text-info">{{
                                                    zbroj
                                                }}</span>
                                                od {{ zbrojiBodove }}
                                            </p>
                                            <p
                                                class="text-success fw-bold"
                                                v-if="showResults"
                                            >
                                                Polozeno
                                            </p>
                                            <p
                                                class="text-danger fw-bold"
                                                v-if="showNegativeResult"
                                            >
                                                Nije polozeno
                                            </p>
                                        </div>
                                        <button class="btn btn-sm btn-outline-primary" @click="newTest">Povratak</button>
                                    </ul>
                                    <p></p>
                                </div>
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
                                        class="mt-3"
                                        :disabled="
                                            answeredQuestions.includes(
                                                currentQuestionIndex
                                            ) || existUserMessage
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

                                </label>
                            </div>
                        </div>
                        <div
                            v-if="!isTestFinished"
                            class="d-flex flex-row justify-content-between align-items-center p-3 bg-white"
                        >
                            <button
                                :disabled="isTestFinished || existUserMessage"
                                class="btn btn-sm btn-primary d-flex align-items-center btn-danger"
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
                                        ) || existUserMessage
                                    "
                                    class="btn btn-primary btn-sm me-2"
                                    @click="spremiOdgovor()"
                                >
                                    Spremi
                                </button>

                                <button
                                    :disabled="existUserMessage"
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
                                    :disabled="existUserMessage"
                                    v-else
                                    class="btn btn-sm btn-primary border-success align-items-center btn-success"
                                    type="button"
                                    @click="nextQuestion"
                                >
                                    Next
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div
                                v-if="existUserMessage"
                                class="alert alert-warning col-lg-6 ms-5"
                            >
                                Imate pravo na samo jedan pokusaj za rjesavanje
                                testa!
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
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            isLoggedIn: false,
            tests: [],
            testovi: [],
            currentQuestionIndex: 0,
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
            results: [],
            zbroj: null,
            existUser: false,
            existUserMessage: "",
            isExistTest:null,
            workingTest:false,
        };
    },
    created() {
        this.dohvatiTestove();
        this.isExist();
    },
    mounted() {
        this.fetchCsrfToken();
    },
    computed: {
        ...mapGetters(["loggedInUser"]),
        isLoggedIn() {
            return this.loggedInUser !== null;
        },
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
                    (this.existUser = true), console.log(error);
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
            this.getResults();
            this.currentQuestionIndex = 0;
            this.trenutniBroj = 1;
            this.zbrojiBodove = null;
            this.isExistTest = this.selectedTestId;
            this.isExist();
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
            this.workingTest = true;
            console.log("Prije novog spremanja", this.totalPoints);
            const selectedAnswerId = this.selectedAnswerId;
            /* console.log("ID ODGOVORA", selectedAnswerId); */
            const OdgovorNaPitanje =
                this.selectedAnswerId[this.currentQuestionIndex];
            let isCurrentAnswerCorrect = false; // Dodajte varijablu za trenutni odgovor
            selectedAnswerId.forEach((element) => {
                if (element == "Da") {
                    isCurrentAnswerCorrect = true; // Postavite na true ako je odgovor točan
                } else if ((element = "Ne")) {
                    isCurrentAnswerCorrect = false;
                }
            });
            let bodPoPitanju;
            if (isCurrentAnswerCorrect) {
                this.isAnswerCorrect = true;
                this.totalPoints +=
                    this.tests.questions[this.currentQuestionIndex].bodovi;
                bodPoPitanju =
                    this.tests.questions[this.currentQuestionIndex].bodovi;
                console.log(this.totalPoints);
            } else if (!isCurrentAnswerCorrect) {
                this.isAnswerCorrect = false;
                this.pokaziOdgovor = true;
                this.tests.questions[this.currentQuestionIndex].bodovi;
                bodPoPitanju =
                    this.tests.questions[this.currentQuestionIndex].bodovi;
                bodPoPitanju = 0;
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
            console.log("Na ovaj odgovor dobili ste ---> ", bodPoPitanju);

            const Podaci = {
                user_id: "",
                test_id: this.tests.id,
                pitanje:
                    this.tests.questions[this.currentQuestionIndex].pitanje,
                odgovor: OdgovorNaPitanje,
                zbrojBodova: bodPoPitanju,
            };

            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;

            axios
                .post("/rezultat", Podaci)
                .then((response) => {
                    this.poruka = response.data.poruka;

                    this.form = {
                        user_id: "",
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
            this.getResults();
            console.log(this.pitanja);
        },

        getResults() {
            axios.get(`/getResults/${this.isExistTest}`).then((response) => {
                this.results = response.data.results;

                this.zbroj = response.data.zbroj;
            });
        },
        newTest() {
            window.location.reload();
        },

        isExist() {
            axios.get(`/isExist/${this.isExistTest}`).then((response) => {
                this.existUserMessage = response.data.existUser;
                console.log("EXIST IS ", this.isExistTest)
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
