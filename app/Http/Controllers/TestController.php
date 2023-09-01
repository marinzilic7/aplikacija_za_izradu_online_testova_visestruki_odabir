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
        $test->create($data);
        return response()->json(['poruka' => 'Test dodan']);
    }

    public function getTest(){
        $test = Test::get();
        return response()->json($test);
    }

    public function deleteTest($id){
        $test = Test::findorFail($id);
        $test->delete();
        return response()->json(['poruka' => 'Test izbrisan']);
    }

}
