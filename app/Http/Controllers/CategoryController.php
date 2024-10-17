<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('category.index',['categories' => $categories]);
    }

    public function show(Category $category){
        
        return view('category.show',['category' => $category]);
    }

    public function store(){
        $validatedData = request()->validate([
            'category' =>'required|unique:categories,name',
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',

        ]);
        if (!$validatedData) return redirect('/categories')->flash('error','Failed to add category');
        $category = Category::create([
            'name' => request('category'),
        ]);
        CategoryPrice::create([
            'category_id' =>  $category->id,
            'created_by' => Auth::id(),
            'min_price' => request('min_price'),
            'max_price' => request('max_price'),
            'start_date' => Carbon::parse(request('start_date')),
            'end_date' => Carbon::parse(request('end_date')),
        ]);
    
        flash()->success('Category created successfully');
        return redirect('/categories');
    }

    public function update(Request $request, $id){

    }

    public function destroy(){
        Category::destroy(request('category'));
        return redirect('/categories');
    }

}
