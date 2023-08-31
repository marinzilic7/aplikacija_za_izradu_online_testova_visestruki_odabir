<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <a class="navbar-brand ms-3 text-light " href="#">TestApp</a>
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
                        <RouterLink class="text-light text-decoration-none  " to="/">Home</RouterLink>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item active">
                        <RouterLink class="me-3 text-light text-decoration-none" to="/register">Register</RouterLink>
                    </li>
                    <li>
                        <RouterLink class="me-3 text-light text-decoration-none" to="/login">Login</RouterLink>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <RouterView />
</template>

<style lang="scss" scoped></style>
