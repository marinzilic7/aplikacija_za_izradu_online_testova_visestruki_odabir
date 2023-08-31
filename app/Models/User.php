<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'ime', 'prezime', 'email', 'lozinka','potvrda_lozinke'
    ];
    use HasFactory;
}
