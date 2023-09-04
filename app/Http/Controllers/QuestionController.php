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

            ],
            [
                'pitanje.required' => 'Obazeno.',

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
