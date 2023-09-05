<template>
    <div class="container mt-5 d-flex justify-content-center">
        <div class="row col-lg-4">
            <select v-model="selectedTestId" @change="selectTest" >
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
                                class="d-flex flex-row justify-content-between align-items-center"
                            >
                                <h4>{{ tests.ime }}</h4>
                                <p><span>{{trenutniBroj}}</span> of  {{ tests.questions.length }} </p>

                            </div>
                            <p>{{ tests.opis }}</p>
                        </div>
                        <div class="question bg-white p-3 border-bottom">
                            <div
                                class="d-flex flex-row align-items-center question-title"
                            >
                                <h3 class="text-danger">Q.</h3>
                                <h5
                                    class="mt-1 ml-2"
                                    v-if="tests.questions.length > 0"
                                >
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
                                        type="radio"
                                        :name="
                                            'answer_' +
                                            tests.questions[
                                                currentQuestionIndex
                                            ].id
                                        "
                                        :value="answer.id"
                                    />
                                    {{ answer.odgovor }}
                                </label>
                            </div>
                        </div>
                        <div
                            class="d-flex flex-row justify-content-between align-items-center p-3 bg-white"
                        >
                            <button
                                class="btn btn-primary d-flex align-items-center btn-danger"
                                type="button"
                                @click="previousQuestion"
                            >
                                Previous
                            </button>
                            <button
                                class="btn btn-primary border-success align-items-center btn-success"
                                type="button"
                                @click="nextQuestion"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tests: [],
            testovi: [],
            currentQuestionIndex: 0, // Dodajte trenutni indeks pitanja
            selectedTestId: '',
            showTest:false,
            trenutniBroj:1,
        };
    },
    created() {
        this.dohvatiTestove();
    },
    methods: {
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
            if (this.currentQuestionIndex < this.tests.questions.length - 1) {
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
            if (this.selectedTestId !== null) {
                axios
                    .get(`/dohvatiTestove/${this.selectedTestId}`)
                    .then((response) => {
                        this.tests = response.data;
                        this.showTest=true,
                        this.currentQuestionIndex = 0; // Resetujte indeks pitanja na početak
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
