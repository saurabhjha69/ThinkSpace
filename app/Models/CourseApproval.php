<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseApproval extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function approvedBy(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function reappliesForApproval(){
        return $this->hasMany(ReappliedApprovals::class,'approval_id','id');
    }

}
