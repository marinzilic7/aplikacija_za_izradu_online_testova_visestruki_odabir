<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registerUser(Request $request)
    {
        $podaci = $request->validate(
            [
                'ime' => 'required|min:3',
                'prezime' => 'required',
                'email' => 'required|email',
                'lozinka' => 'required|min:5|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
                'potvrda_lozinke' => 'required|same:lozinka'
            ],
            [
                'ime.required' => "Ime je obavezno.",
                'ime.min' => "Ime mora imati minimalno 3 slova.",
                'prezime.required' => "Prezime je obavezno.",
                'email.required' => "Email je obavezan.",
                'email.email' => "Unesite tocan format email adrese.",
                'lozinka.required' => "Lozinka je obavezna.",
                "lozinka.min" => "Lozinka treba imati minimalno 5 znakova.",
                "lozinka.regex" => "Lozinka treba imati bar jedno veliko slovo i bar jedan broj.",
                "potvrda_lozinke.required" => "Potvrda lozinke je obavezna.",
                "potvrda_lozinke.same" => "Vasa lozinka i potvrda vase lozinke nisu iste!",

            ]
        );

        $postojiEmail = User::where('email', $podaci['email'])->first();
        if ($postojiEmail) {
            return response()->json(['postojiEmail' => 'Postoji korisnik s tim emailom'], 422);
        }


        $podaci['lozinka'] = Hash::make($podaci['lozinka']);
        $podaci['potvrda_lozinke'] = Hash::make($podaci['potvrda_lozinke']);

        $korisnik = new User();
        $korisnik->create($podaci);

        return response()->json(['poruka' => 'Uspjesna registracija']);
    }
}
