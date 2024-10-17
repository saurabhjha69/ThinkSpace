<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReappliedApprovals extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
    public function approvedBy(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function approval(){
        return $this->belongsTo(CourseApproval::class,'approval_id','id');
    }
}
