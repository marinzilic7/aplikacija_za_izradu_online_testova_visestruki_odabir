<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;
use LDAP\Result;

/* Registracija i prijava */

Route::post('/registerUser',[UserController::class,'registerUser']);
Route::post('/loginUser',[UserController::class,'loginUser']);
Route::get('/isLogged',[UserController::class,'isLogged']);
Route::post('/logout',[UserController::class,'logoutUser']);

/* Test */

Route::post('/addTest',[TestController::class,'addTest']);
Route::get('/getTest',[TestController::class,'getTest']);
Route::post('/deleteTest/{id}',[TestController::class,'deleteTest']);
Route::get('/dohvatiTestove/{id}',[TestController::class,'dohvatiTestove']);

/* Pitanje */

Route::post('/addQuestion',[QuestionController::class,'addQuestion']);
Route::get('/getPitanje',[QuestionController::class,'getPitanje']);

/* Odgovor */

Route::post('/addAnswer',[AnswerController::class,'addAnswer']);

/* Rezultat */

Route::post('/rezultat',[ResultController::class,'rezultat']);
Route::get('/getResults/{id}',[ResultController::class,'getResults']);
Route::get('/isExist/{id}',[ResultController::class,'isExist']);
Route::get('/getRez',[ResultController::class,'getRez']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
