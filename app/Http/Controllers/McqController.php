<?php

namespace App\Http\Controllers;

use App\Models\Mcq;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class McqController extends Controller
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

    public function update(Mcq $mcq){
        $validatedData = request()->validate([
            'question' =>'required',
            'option1' =>'required',
            'option2' =>'required',
            'option3' =>'required',
            'option4' =>'required',
            'ans' => 'required',
        ]);
        if(!$mcq->update($validatedData)){
            throw ValidationException::withMessages(['fail'=>'failed to update mcq']);
        }
        
        return redirect('quiz/'.$mcq->quiz->id);
    }

    public function destroy($id){

    }
}
