<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'test_id', 'pitanje', 'odgovor', 'zbrojBodova',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class,'test_id');
    }
    use HasFactory;
}
