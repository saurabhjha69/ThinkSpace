<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function hasUserRated(){
        return $this->ratings()->where('course_id',$this->id)->where('user_id',Auth::id())->exists();
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function prerequisites(){
        return $this->belongsToMany(Prerequisite::class);
    }

    public function introvideo(){
        return $this->belongsTo(Video::class,'video_id','id');
    }

    public function purchasedCourses(){
        return $this->hasMany(Purchasedcourse::class);
    }

    public function averageRating()
    {
        // Assuming 'ratings' is the relationship name
        $totalRatings = $this->ratings()->avg('stars');

        return $totalRatings !== null ? round($totalRatings, 1) : 0;
    }

    public function totalCourseDuration(){
        $totalDuration = 0;
        foreach($this->modules as $module){
            $totalDuration += $module->totalDuration();
        }
        return $totalDuration;
    }

    public function lectures($param){
        $lectures = 0;
        foreach($this->modules as $module){
            foreach($module->submodules as $submodule){
                if($submodule->video){
                    $lectures++;
                }
            }
        }
        return $lectures;
    }

    public function isCoursePurchased($id){
        return $this->payments()
        ->where('user_id',$id)
        ->where('status','complete')
        ->where('payment_status','paid')
        ->exists();
    }

    public function calcDiscount(Course $course){
        $current_price = $course->price;
        $est_price = $course->est_price;
        $discount_amount = $est_price - $current_price;
        $discount_perc = ($discount_amount * 100 )/$est_price;
        return round($discount_perc, 2);
    }

    public function progress(){
        $moduleCount = $this->modules()->count();
        $completedSubModuleValue = 0;
        foreach($this->modules()->get() as $module){
            $completedSubModuleValue += $module->howMuchCompleted();
        }
        $completedPercentage = $completedSubModuleValue / $moduleCount;
        return round($completedPercentage);
        // return 70;
    }
    
}
