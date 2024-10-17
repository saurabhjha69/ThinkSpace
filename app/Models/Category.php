<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function courses(){
        return $this->hasMany(Course::class,'category_id','id');
    }
    public function categoryPrice(){
        return $this->hasOne(CategoryPrice::class,'category_id','id'); 
    }
    // public function categoryPriceRange(){
    //     return "(".$this->categoryPrice?->min_price."-".$this->categoryPrice?->max_price.")";
    // }

    public function totalWatchHours(){
        $totalDuration = 0;
        foreach($this->courses as $course){
            $totalDuration += (int)$course->totalWatchHours();
        }
        return $totalDuration == 0 ? 0 : $totalDuration;
    }

    public function totalLearners(){
        $total = 0;
        foreach($this->courses as $course){
            $total += $course->users->count();
        }
        return $total ? $total : 0;
    }
    public function totalInstructors(){
        return $this->courses->where('category_id',$this->id)->groupby('user_id')->count();
    }
    
}
