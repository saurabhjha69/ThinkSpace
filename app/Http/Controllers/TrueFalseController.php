<?php

namespace App\Http\Controllers;

use App\Models\Truefalse;
use Illuminate\Http\Request;

class TrueFalseController extends Controller
{
    public function index(){

    }

    public function create(){

    }

    public function store(Request $request){

    }

    public function show($id){

    }

    public function edit($id){

    }

    public function update(Truefalse $truefalse){
        request()->validate([
            'question' =>'required',
            'ans' =>'required',
        ]);
        $truefalse->update([
            'question' => request('question'),
            'ans' => (int)request('ans'),
        ]);
        
        return redirect('quiz/'.$truefalse->quiz->id);
    }

    public function destroy($id){

    }
}
