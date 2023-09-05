<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function addAnswer(Request $request)
    {

        $data = $request->validate(
            [
                'question_id' => 'required',
                'test_id' => 'required',
                'odgovor' => 'required',
                'tocanOdgovor' => 'required',


            ],
            [
                'odgovor.required' => 'Obavezno.',
                'tocanOdgovor.required' => 'Obavezno.',


            ]
        );

        $odgovor = new Answer();
        $odgovor->create($data);
        return response()->json(['poruka' => 'Uspjesno dodano']);
    }
}
