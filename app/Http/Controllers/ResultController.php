<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{

    private $zbroj;

    public function rezultat(Request $request)
    {
        $data = $request->validate([
            'user_id' => '',
            'test_id' => 'required',
            'pitanje' => 'required',
            'odgovor' => 'required',
            'zbrojBodova' => 'required',
            'sumPoints' => '',
        ]);

        $result = new Result();
        $data['user_id'] = auth()->id();

        if (array_key_exists('sumPoints', $data)) {
            if ($data['sumPoints'] == null) {
                $data['sumPoints'] = $data['zbrojBodova'];
            } else {
                $data['sumPoints'] = $this->zbroj;
            }
        } else {
            $data['sumPoints'] = $data['zbrojBodova'];
        }

        $result->create($data);
        return response()->json(['poruka' => 'Test dodan']);
    }

    public function getResults($id)
    {

        $testId = $id;
        $userId = auth()->user()->id;


        $results = Result::where('user_id', $userId)
            ->with('users')->where('test_id', $testId)
            ->get();

        $this->zbroj = Result::where('user_id', $userId)->where('test_id', $testId)->sum('zbrojBodova');



        return response()->json(['results' => $results, 'zbroj' => $this->zbroj]);
    }

    public function isExist($id)
    {
        $userId = auth()->user()->id;
        $testId = $id;
        $existUser = Result::where('user_id', $userId)
            ->where('test_id', $testId)
            ->exists();
        if ($existUser) {
            return response()->json(['existUser' => true]);
        }
    }

    public function getRez()
    {
        $users = User::all();

        $totals = [];

        foreach ($users as $user) {
            $hasResults = Result::where('user_id', $user->id)->exists();

            if ($hasResults) {
                $totalPoints = Result::where('user_id', $user->id)->sum('zbrojBodova');

                $totals[] = [
                    'user_id' => $user->id,
                    'ime' => $user->ime,
                    'ukupniBodovi' => $totalPoints,
                ];
            }
        }

        return response()->json(['totals' => $totals]);
    }

    public function deleteRez(){
        Result::truncate();
        return response()->json(['message' => 'Svi rezultati su izbrisani.']);
    }
}
