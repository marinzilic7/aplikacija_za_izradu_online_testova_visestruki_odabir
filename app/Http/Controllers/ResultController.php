<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
class ResultController extends Controller
{
    public function rezultat(Request $request)
    {
        $data = $request->validate([
            'test_id' => 'required',
            'pitanje' => 'required',
            'odgovor' => 'required',
            'zbrojBodova' => 'required',
        ]);

        $result = new Result();
        $result->create($data);
        return response()->json(['poruka' => 'Test dodan']);
    }
}
