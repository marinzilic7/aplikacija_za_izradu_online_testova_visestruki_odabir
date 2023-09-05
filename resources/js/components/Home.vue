<template>
    <div>
        <div class="container mt-5">
            <div class="d-flex justify-content-center row">
                <div class="col-md-10 col-lg-10">
                    <div class="border shadow-lg">
                        <div class="question bg-white p-3 border-bottom">
                            <div
                                class="d-flex flex-row justify-content-between align-items-center"
                            >
                                <h4>{{ tests.ime }}</h4>
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
            currentQuestionIndex: 0, // Dodajte trenutni indeks pitanja
        };
    },
    created() {
        this.dohvatiTestove();
    },
    methods: {
        dohvatiTestove() {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .get("/dohvatiTestove/1")
                .then((response) => {
                    this.tests = response.data;
                    console.log(response.data);

                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        nextQuestion() {
            if (this.currentQuestionIndex < this.tests.questions.length - 1) {
                this.currentQuestionIndex++;
            }
        },

        previousQuestion() {
            if (this.currentQuestionIndex > 0) {
                this.currentQuestionIndex--;
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
