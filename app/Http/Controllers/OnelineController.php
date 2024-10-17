<?php

namespace App\Http\Controllers;

use App\Models\Oneline;
use Illuminate\Http\Request;

class OnelineController extends Controller
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

    public function update(Oneline $oneline){
        $validatedData = request()->validate([
            'question' =>'required',
            'ans' =>'required',
        ]);
        $oneline->update($validatedData);
        
        return redirect('quiz/'.$oneline->quiz->id);
    }

    public function destroy($id){

    }
}
