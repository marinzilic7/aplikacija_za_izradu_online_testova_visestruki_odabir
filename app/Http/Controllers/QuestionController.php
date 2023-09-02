<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function addQuestion(Request $request)
    {

        $data = $request->validate(
            [
                'test_id' => 'required',
                'pitanje' => 'required',
                'odgovor1' => 'required',
                'odgovor2' => 'required',
                'odgovor3' => 'required',
            ],
            [
                'pitanje.required' => 'Obazeno.',
                'odgovor1.required' => 'Obavezno.',
                'odgovor2.required' => 'Obavezno.',
                'odgovor3.required' => 'Obavezno.',
            ]
        );

        $pitanje = new Question();
        $pitanje->create($data);
        return response()->json(['poruka' => 'Uspjesno dodano']);
    }
}
