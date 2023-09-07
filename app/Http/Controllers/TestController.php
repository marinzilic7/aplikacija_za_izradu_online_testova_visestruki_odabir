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



        /* $test = Test::with('user', 'questions', 'answers')->get();
        return response()->json($test); */
    }

    public function deleteTest($id)
    {
        $test = Test::findorFail($id);
        $test->delete();
        return response()->json(['poruka' => 'Test izbrisan']);
    }


    public function dohvatiTestove($id)
    {
        $test = Test::with('user', 'questions.answers')->find($id);
        return response()->json($test);
    }

    public function updateTest(Request $request, $id){

        $test = Test::findOrFail($id);
        $data = $request->validate([
            'ime' => 'required|string',
            'opis' => 'required|string',

        ]);

        $test->ime=$data['ime'];
        $test->opis=$data['opis'];
        $test->save();
        return response()->json([
            'poruka' => 'Test uspjesno uredjen',
            'test' => $test,
        ]);
    }
}
