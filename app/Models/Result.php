<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'user_id','test_id', 'pitanje', 'odgovor', 'zbrojBodova',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class,'test_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    use HasFactory;
}
