<template>
    <div class="container d-flex flex-column align-items-center mt-5">
        <div class="row col-lg-6">
            <form class="border p-5 shadow-lg" @submit.prevent="loginUser">
                <input type="hidden" v-model="this.POST" />
                <input type="hidden" name="" v-model="this.csrfToken" />
                <div class="form-group mt-4">
                    <label for="exampleInputEmail1">Email adresa</label>
                    <input
                        type="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vas email"
                        v-model="form.email"
                    />
                </div>
                <p v-if="errors.email" class="text-danger">
                    {{ errors.email[0] }}
                </p>
                <div class="form-group mt-4">
                    <label for="exampleInputPassword1">Lozinka</label>
                    <input
                        type="password"
                        class="form-control"
                        id="exampleInputPassword1"
                        placeholder="Unesite vasu lozinku"
                        v-model="form.lozinka"
                    />
                </div>
                <p v-if="errors.lozinka" class="text-danger">
                    {{ errors.lozinka[0] }}
                </p>

                <button type="submit" class="btn btn-primary w-100 mt-4">
                    Prijava
                </button>
                <div v-if="successRegg" class="mt-3">
                    <p class="alert alert-success">Uspjesna prijava!</p>
                </div>

                <div v-if="falseReg" class="mt-3">
                    <p class="alert alert-danger">Pogresan email ili lozinka</p>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";
export default {
    data() {
        return {
            form: {
                email: "",
                lozinka: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},
            poruka: "",
            successReg:false,
            falseReg:false,
            logMessage: "",
        };
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
        loginUser() {
            const Podaci = {
                email: this.form.email,
                lozinka: this.form.lozinka,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;

            axios
                .post("loginUser", Podaci)
                .then((response) => {
                    this.logMessage = response.data.poruka;
                    this.successReg = true;

                    if (this.logMessage == "Uspješna prijava") {
                        this.$store.dispatch(
                            "setLoginMessage",
                            this.logMessage
                        );
                        this.$store.commit(
                            "setLoggedInUser",
                            response.data.user
                        );
                        this.successRegg = true;
                        this.falseReg = false;
                        this.$router.push("/");
                    } else {
                        this.falseReg = true;
                        this.successRegg = false;
                    }
                })
                .catch((error) => {
                    console.log("Error:", error);
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
    },
    ...mapActions(["setLoginMessage"]),
};
</script>

<style lang="scss" scoped></style>
