<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\String\b;

class UserController extends Controller
{
    public function registerUser(Request $request)
    {
        $podaci = $request->validate(
            [
                'ime' => 'required|min:3',
                'prezime' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:5|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
                'potvrda_lozinke' => 'required|same:password'
            ],
            [
                'ime.required' => "Ime je obavezno.",
                'ime.min' => "Ime mora imati minimalno 3 slova.",
                'prezime.required' => "Prezime je obavezno.",
                'email.required' => "Email je obavezan.",
                'email.email' => "Unesite tocan format email adrese.",
                'password.required' => "Lozinka je obavezna.",
                "password.min" => "Lozinka treba imati minimalno 5 znakova.",
                "password.regex" => "Lozinka treba imati bar jedno veliko slovo i bar jedan broj.",
                "potvrda_lozinke.required" => "Potvrda lozinke je obavezna.",
                "potvrda_lozinke.same" => "Vasa password i potvrda vase lozinke nisu iste!",

            ]
        );

        $postojiEmail = User::where('email', $podaci['email'])->first();
        if ($postojiEmail) {
            return response()->json(['postojiEmail' => 'Postoji korisnik s tim emailom'], 422);
        }


        $podaci['password'] = Hash::make($podaci['password']);
        $podaci['potvrda_lozinke'] = Hash::make($podaci['potvrda_lozinke']);

        $korisnik = new User();
        $korisnik->create($podaci);

        return response()->json(['poruka' => 'Uspjesna registracija']);
    }

    public function loginUser(Request $request){
        $data = $request-> validate(
            [
            'email' => 'required',
            'password' => 'required'
        ],
        [
            'email.required' => 'Email je obavezan',
            'password.required' => 'Lozinka je obavezna'
        ]
    );



    if (Auth::attempt($data)) {
        $user = Auth::user();
        return response()->json(['poruka' => 'Uspješna prijava', 'user' => $user]);
    } else {

        return response()->json(['poruka' => 'Neuspješna prijava']);


    }

    }

    public function isLogged()
    {

        $user = Auth::user();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(null);
        }
    }

    public function logoutUser()
    {
        Auth::logout();
        return response()->json(['redirect' => '/login']);
    }


}
