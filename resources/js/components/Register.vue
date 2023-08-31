<template>
    <div class="container d-flex flex-column align-items-center mt-5">
        <div class="row col-lg-6">
            <form class="border p-5 shadow-lg" @submit.prevent="registerUser()">
                <input type="hidden" v-model="this.POST" />
                <input type="hidden" name="" v-model="this.csrfToken" />
                <div class="form-group">
                    <label for="exampleInputEmail1">Ime</label>
                    <input
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vase ime"
                        v-model="form.ime"
                    />
                </div>
                <p v-if="errors.ime" class="text-danger">
                                {{ errors.ime[0] }}
                            </p>
                <div class="form-group mt-4">
                    <label for="exampleInputEmail1">Prezime</label>
                    <input
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vase prezime"
                        v-model="form.prezime"
                    />
                </div>
                <p v-if="errors.prezime" class="text-danger">
                                {{ errors.prezime[0] }}
                            </p>
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
                        v-model="form.password"
                    />
                </div>
                 <p v-if="errors.password" class="text-danger">
                                {{ errors.password[0] }}
                            </p>
                <div class="form-group mt-4">
                    <label for="exampleInputPassword1">Ponovi lozinku</label>
                    <input
                        type="password"
                        class="form-control"
                        id="exampleInputPassword1"
                        placeholder="Ponovi lozinku"
                        v-model="form.potvrda_lozinke"
                    />
                </div>
                <p v-if="errors.potvrda_lozinke" class="text-danger">
                                {{ errors.potvrda_lozinke[0] }}
                            </p>
                <button type="submit" class="btn btn-primary w-100 mt-4">
                    Registriraj se
                </button>
                <div v-if="successReg" class="alert alert-info mt-4"><p>{{ poruka }} <span class="text-primary"><a class="text-decoration-none" href="/login">Prijavite se</a></span></p></div>
                <div v-if="postojiEmail" class="alert alert-warning mt-4"><p>Postoji korisnik sa tom email adresom!</p></div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            form: {
                ime: "",
                prezime: "",
                email: "",
                password: "",
                potvrda_lozinke: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},
            poruka: "",
            successReg:false,
            postojiEmail:false,
        };
    },
    mounted(){
        this.fetchCsrfToken();
    },
    methods:{
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
        registerUser(){
            const Podaci = {
                ime:this.form.ime,
                prezime:this.form.prezime,
                email:this.form.email,
                password:this.form.password,
                potvrda_lozinke:this.form.potvrda_lozinke
            };

            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;

            axios
                .post("/registerUser", Podaci)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.successReg = true;
                    this.form = {
                        ime: "",
                        prezime: "",
                        email: "",
                        password: "",
                        potvrda_lozinke: "",
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
        }
    }

</script>

<style lang="scss" scoped></style>
