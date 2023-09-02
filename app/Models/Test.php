<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'user_id', 'ime', 'opis'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    use HasFactory;
}
