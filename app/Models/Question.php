<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'test_id', 'pitanje', 'odgovor1','odgovor2','odgovor3'
    ];


    public function test()
    {
        return $this->belongsTo(Test::class,'test_id');
    }
    use HasFactory;
}
