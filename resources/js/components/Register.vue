<template>
    <div class="container d-flex flex-column align-items-center mt-5">
        <div class="row col-lg-6">
            <form class="border p-5 shadow-lg">
                <div class="form-group">
                    <label for="exampleInputEmail1">Ime</label>
                    <input
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vase ime"
                    />

                </div>
                <div class="form-group mt-4">
                    <label for="exampleInputEmail1">Prezime</label>
                    <input
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vase prezime"
                    />

                </div>
                <div class="form-group mt-4">
                    <label for="exampleInputEmail1">Email adresa</label>
                    <input
                        type="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vas email"
                    />

                </div>
                <div class="form-group mt-4">
                    <label for="exampleInputPassword1">Lozinka</label>
                    <input
                        type="password"
                        class="form-control"
                        id="exampleInputPassword1"
                        placeholder="Unesite vasu lozinku"
                    />
                </div>
                 <div class="form-group mt-4">
                    <label for="exampleInputPassword1">Ponovi lozinku</label>
                    <input
                        type="password"
                        class="form-control"
                        id="exampleInputPassword1"
                        placeholder="Ponovi lozinku"
                    />
                </div>


                <button type="submit" class="btn btn-primary w-100 mt-4">Registriraj se</button>
            </form>
        </div>
    </div>
</template>

<script setup></script>

<style lang="scss" scoped></style>
