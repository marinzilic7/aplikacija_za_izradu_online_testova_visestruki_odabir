<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_id', 'test_id','odgovor', 'tocanOdgovor'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class,'user_id');
    }
    use HasFactory;
}
