<?php

namespace App\Http\Controllers;

use App\Models\Multianswer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MultianswerController extends Controller
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

    public function update(Multianswer $multianswer){
        request()->validate([
            'question' =>'required',
            'option1' =>'required',
            'option2' =>'required',
            'option3' =>'required',
            'option4' =>'required',
        ]);
        $choiceCounter = 4;
        for ($x = 1; $x <= 4; $x++) {
            if(request('choice'.$x)===null){
                $choiceCounter--;
            }
        }
        if($choiceCounter < 1){
            throw ValidationException::withMessages(['choice'=>'At least one choice is required']);
        }
    
        $multianswer->update([
            'question' => request('question'),
            'choice1' => request('choice1'),
            'choice2' => request('choice2'),
            'choice3' => request('choice3'),
            'choice4' => request('choice4'),
            'option1' => request('option1'),
            'option2' => request('option2'),
            'option3' => request('option3'),
            'option4' => request('option4'),
        ]);
        
        return redirect('quiz/'.$multianswer->quiz->id);
    }

    public function destroy($id){

    }
}
