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
        // dd(request());
        request()->validate([
            'question' =>'required',
            'ans' =>'required',
        ]);
        $truefalse->update([
            'question' => request('question'),
            'ans' => request('ans') == '0' ? 0 : 1,
        ]);
        $res = $truefalse->save();
        if(!$res){
            flash()->error('Failed to update the question');
            return back();
        }
        flash()->success('Question updated successfully');
        return redirect()->back();
    }

    public function destroy($id){

    }
}
