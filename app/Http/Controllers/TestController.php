<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function addTest(Request $request)
    {

        $data = $request->validate(
            [
                'ime' => 'required',
                'opis' => 'required'
            ],
            [
                'ime.required' => 'Obazeno.',
                'opis.required' => 'Obavezno.'
            ]
        );

        $test = new Test();
        $data['user_id'] = auth()->id();
        $test->create($data);
        return response()->json(['poruka' => 'Test dodan']);
    }

    public function getTest()
    {
        $test = Test::with('user', 'questions', 'answers')->get();
        return response()->json($test);
    }

    public function deleteTest($id)
    {
        $test = Test::findorFail($id);
        $test->delete();
        return response()->json(['poruka' => 'Test izbrisan']);
    }


    public function dohvatiTestove()
    {
        $test = Test::with('user', 'questions.answers')->find(1);
        return response()->json($test);
    }
}
