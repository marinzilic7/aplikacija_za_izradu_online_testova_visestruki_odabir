<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/* Registracija i prijava */

Route::post('/registerUser',[UserController::class,'registerUser']);
Route::post('/loginUser',[UserController::class,'loginUser']);
Route::get('/isLogged',[UserController::class,'isLogged']);
Route::post('/logout',[UserController::class,'logoutUser']);

/* Test */

Route::post('/addTest',[TestController::class,'addTest']);
Route::get('/getTest',[TestController::class,'getTest']);
Route::post('/deleteTest/{id}',[TestController::class,'deleteTest']);



Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
