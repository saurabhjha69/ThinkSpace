<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function averageRating(Course $course){
        $totalRatings = $this->where('course_id', $course->id)->avg('rating');
        return $totalRatings !== null ? round($totalRatings, 1) : 0;
    }
}
