<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function submodules(){
        return $this->hasMany(Submodule::class);
    }

    public function quizzes(){
        return $this->hasMany(Quiz::class);
    }



    public function totalDuration(){
        return $this->submodules()->join('videos', 'submodules.video_id', '=', 'videos.id')
        ->sum('videos.duration');
    }

    public function howMuchCompleted(){
        $submoduleCount = $this->submodules()->count();
        $completedSubModule = 0;
        foreach($this->submodules()->get() as $submodule){
            if($submodule->isMarkedCompleted()){
                $completedSubModule +=1;
            }
        }
        if($submoduleCount === 0){
            return 0;
        }
        $completedPercentage = ($completedSubModule*100) / $submoduleCount;
        return $completedPercentage;
    }
}

