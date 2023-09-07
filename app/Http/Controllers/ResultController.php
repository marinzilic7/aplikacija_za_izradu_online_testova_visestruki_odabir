<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;

class ResultController extends Controller
{
    public function rezultat(Request $request)
    {
        $data = $request->validate([
            'user_id' => '',
            'test_id' => 'required',
            'pitanje' => 'required',
            'odgovor' => 'required',
            'zbrojBodova' => 'required',
        ]);

        $result = new Result();
        $data['user_id'] = auth()->id();
        $result->create($data);
        return response()->json(['poruka' => 'Test dodan']);
    }

    public function getResults()
    {


        $userId = auth()->user()->id;


        $results = Result::where('user_id', $userId)
            ->with('users')
            ->get();

        $zbroj = Result::where('user_id', $userId)->sum('zbrojBodova');



        return response()->json(['results' => $results, 'zbroj' => $zbroj]);
    }
}
