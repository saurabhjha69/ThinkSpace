<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('category',['categories' => $categories]);
    }

    public function show(){

    }

    public function store(){
        $validatedData = request()->validate([
            'category' =>'required|unique:categories,name',
        ]);
        if (!$validatedData) throw ValidationException::withMessages(['category']);
        Category::create([
            'name' => request('category'),
        ]);
    
        return redirect('/categories');
    }

    public function update(Request $request, $id){

    }

    public function destroy(){
        Category::destroy(request('category'));
        return redirect('/categories');
    }

}
