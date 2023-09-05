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
                'bodovi' => 'required',

            ],
            [
                'pitanje.required' => 'Obavezno.',
                'bodovi.required' => 'Obavezno.',

            ]
        );

        $pitanje = new Question();
        $pitanje->create($data);
        return response()->json(['poruka' => 'Uspjesno dodano']);
    }

    public function getPitanje(){
        $test = Question::get();
        return response()->json($test);
    }
}
