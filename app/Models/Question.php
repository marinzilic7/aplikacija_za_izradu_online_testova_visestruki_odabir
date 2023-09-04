<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'test_id', 'pitanje'
    ];


    public function test()
    {
        return $this->belongsTo(Test::class,'test_id');
    }

    public function answers()
    {
        return $this->hasMany(Question::class);
    }
    use HasFactory;
}
