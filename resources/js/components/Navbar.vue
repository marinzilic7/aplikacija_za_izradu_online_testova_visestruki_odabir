<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <a class="navbar-brand ms-3 text-light" href="#">TestApp</a>
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <RouterLink
                            class="text-light text-decoration-none nav-link"
                            to="/"
                            >Home</RouterLink
                        >
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a
                                class="btn btn-primary dropdown-toggle"
                                href="#"
                                role="button"
                                id="dropdownMenuLink"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Test
                            </a>

                            <ul
                                class="dropdown-menu"
                                aria-labelledby="dropdownMenuLink"
                            >
                                <li>
                                    <RouterLink
                                        class="text-dark text-decoration-none nav-link"
                                        to="/test"
                                        >Dodaj test</RouterLink
                                    >
                                </li>
                                <li>
                                    <RouterLink
                                        class="text-dark text-decoration-none nav-link"
                                        to="/test_list"
                                        >Lista testova</RouterLink
                                    >
                                </li>

                            </ul>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li v-if="!isLoggedIn" class="nav-item active">
                        <RouterLink
                            class="me-3 text-light text-decoration-none"
                            to="/register"
                            >Register</RouterLink
                        >
                    </li>
                    <li v-if="!isLoggedIn">
                        <RouterLink
                            class="me-3 text-light text-decoration-none"
                            to="/login"
                            >Login</RouterLink
                        >
                    </li>
                    <li v-else="isLoggedIn">
                        <div class="btn-group dropstart">
                            <button
                                class="btn btn-primary dropdown-toggle text-light nav-link"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                {{ loggedInUser.ime }}
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <button
                                        @click="odjava"
                                        class="dropdown-item p-0 text-center"
                                        type="button"
                                    >
                                        Logout
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <RouterView />
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            isLoggedIn: false,
        };
    },
    computed: {
        ...mapGetters(["loggedInUser"]),
        isLoggedIn() {
            return this.loggedInUser !== null;
        },
    },
    created() {
        this.checkLoginStatus();
    },
    methods: {
        checkLoginStatus() {
            axios
                .get("/isLogged")
                .then((response) => {
                    this.loggedInUser = response.data;

                    this.isLoggedIn = true;
                    console.log(this.isLoggedIn);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        odjava() {
            axios
                .post("/logout")
                .then((response) => {
                    this.isLoggedIn = false;
                    this.loggedInUser = null;
                    this.$store.dispatch("logout");
                    this.$router.push("/login");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
